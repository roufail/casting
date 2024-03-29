<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Client\ClientLoginRequest;
use App\Http\Requests\Client\ClientRegisterRequest;
use App\Http\Requests\Client\ClientActivateRequest;
use App\Http\Requests\Client\ClientRecoveryRequest;
use App\Http\Requests\Api\UpdatePasswordRequest;
use App\Models\Client;
use App\Http\Resources\ClientResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Notifications\NotificationCollection;

use Storage;
class ClientController extends BaseController
{

    public function client() {
        $client = auth('client-api')->user();
        // $success['client'] =  new ClientResource($client);
        // $success['token']  =  $client->token('client')->accessToken;;
        return $this->success(new ClientResource($client), 'client data retrived successfully');
    }

    public function register(ClientRegisterRequest $request){
        $image = "";
        if($request->hasFile('imageFile')){
            $image = $request->imageFile->store("/","clients");
        }
        $request->request->remove('image');
        $request->merge([
            'active'   => 0,
            'password' => bcrypt($request->password),
            'image'    => $image,
        ]);

        $client = Client::create($request->all());
        $success['client'] =  new ClientResource($client);
        $success['token'] =  $client->createToken('client')->accessToken;
        return $this->success($success, 'client registered successfully');
    }



    public function login(ClientLoginRequest $request){
        $credentials = $request->only('phone', 'password');
        if (auth('client')->attempt($credentials)) {
            $client = auth('client')->user();
            // if(!$client->active){
            //     return $this->error([],'client not activated',422);
            // }

            if($request->firebase_token) {
                $client->update([
                    'firebase_token' => $request->firebase_token
                ]);
            }

            $success['client'] =  new ClientResource($client);
            $success['token'] =  $client->createToken('client')->accessToken;
            return $this->success($success, 'client loggedin successfully');
        }else{
            return $this->error([],'credentials wrong',401);
        }
        return $this->error([],'something went wrong');
    }


    public function activate(ClientActivateRequest $request){
        $credentials = $request->only('phone', 'password');

        if(auth('client')->attempt($credentials)){
            $client = auth('client')->user();
            if($client->active){
                return $this->error([],'this client already activated');
            }

            // mobile activation logic
            if($request->code == 1111){
                $updated = $client->update([
                    'active' => 1
                ]);

                if($updated) {
                    $success['client'] =  new ClientResource($client);
                    $success['token'] =  $client->createToken('client')->accessToken;
                    return $this->success($success, 'account activated successfully');
                }
            }else {
                return $this->error([],'activation code is wrong',422);
            }

            if($request->firebase_token) {
                $client->update([
                    'firebase_token' => $request->firebase_token
                ]);
            }


        }else {
            return $this->error([],'credentials is wrong',401);
        }
    }

    public function password_recovery(Request $request){
        $request->validate([
            "phone" => "required"
        ]);
        $phone = $request->only('phone');
        if ($client = Client::where('phone',$phone)->first()) {
            if(!$client->active){
                return $this->error([],'client not activated',422);
            }

            // generete code
            $code = rand(1111,9999);
            $client->password_recovery()->updateOrCreate([
                "user_type" => "client"
            ],[
                "code" => $code,
                "user_type" => "client"
            ]);

            return $this->success(["code" => $code],'Recovery code sent successfully');
        }
        return $this->error([],'phone number not exists');

    }


    public function reset_password(ClientRecoveryRequest $request){
        $phone = $request->only('phone');
        if ($client = Client::where('phone',$phone)->first()) {
            if(!$client->active){
                return $this->error([],'client not activated',422);
            }


            $code = "";
            if($client->password_recovery){
                $code =  $client->password_recovery->code;
            } else {
                return $this->error([],'something went wrong');
            }


            if($request->code ==  $code ) {
                $client->update(["password" => bcrypt($request->password)]);
                return $this->success(['reset' => true], 'password rest successfully');
            }else {
                return $this->error([],'code is wrong',422);
            }
        }
        return $this->error([],'something went wrong');
    }


    public function update_profile(Request $request){
        $image = "";
        $client = auth('client-api')->user();

        if($request->hasFile('imageFile')){
            Storage::disk('clients')->delete($client->image);
            $image = $request->imageFile->store("/","clients");
            $request->request->remove('image');
            $request->merge([
                'image'    => $image,
            ]);
        }

        $client->update($request->all());
        return $this->success(new ClientResource($client), 'client updated successfully');    
    }

    public function update_password(UpdatePasswordRequest $request){
        $client = auth('client-api')->user();
        if(!Hash::check($request->old_password,$client->password)){
            throw new HttpResponseException(
                response()->json([
                  'message' =>'validation errors',
                  'errors'  => ["Old password not correct"]
                ], 422)
              );       
        }

        if($client->update(["password" => bcrypt($request->password)])){
            return $this->success([], 'password updated successfully');

        }
        return $this->error([],'something went wrong');

    }

    public function update_firebase_token(Request $requset) {
        $requset->validate([
            'firebase_token' => 'required'
        ]);
        auth('client-api')->user()->update([
            'firebase_token' => $requset->firebase_token
        ]);
        return $this->success([], 'firebase token updated successfully');
    }


    public function notifications(){
        // $notifications = [];
        // foreach (auth('client-api')->user()->notifications as $key => $notification) {
        //     $notifications[] = load_notification($notification);
        // }
        // return $this->success($notifications, 'notifications retrived successfully');

        $notifications = auth('client-api')->user()->notifications()->paginate(10);
        return $this->success(new NotificationCollection($notifications), 'Notifications retrived successfully');

    }

    public function read_notifications(Request $request){
        $notifications = auth('client-api')->user()->notifications()->find($request->notifications_ids)->markAsRead();
        return $this->success(null, 'Notifications marked as read');
    }

    public function logout(){
        auth('client-api')->user()->tokens()->where('name','client')->each(function ($token, $key) {
            $token->delete();
        });
        return $this->success([], 'client logged out successfully');
    }

    public function payer_favorite_toggle(Request $request) {
        $request->validate([
            'payer_id' => 'required|exists:users,id',
        ]);
        $client = auth('client-api')->user();
        if($client->favorite_payers()->where('payer_id',$request->payer_id)->exists()){
            $client->favorite_payers()->where('payer_id',$request->payer_id)->delete();
            return $this->success([], 'Payer removed form favorite successfully');

        }else {
            $client->favorite_payers()->create([
                'payer_id' => $request->payer_id
            ]);
            return $this->success([], 'Payer added to favorite successfully');
        }
    }



}
