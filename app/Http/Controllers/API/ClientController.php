<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Client\ClientLoginRequest;
use App\Http\Requests\Client\ClientRegisterRequest;
use App\Http\Requests\Client\ClientActivateRequest;
use App\Http\Requests\Client\ClientRecoveryRequest;

use App\Models\Client;
use App\Http\Resources\ClientResource;
class ClientController extends BaseController
{

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
        return $this->success(new ClientResource($client), 'client loggedin successfully');
    }



    public function login(ClientLoginRequest $request){
        $credentials = $request->only('phone', 'password');
        if (auth('client')->attempt($credentials)) {
            $client = auth('client')->user();
            if(!$client->active){
                return $this->error([],'client not activated');
            }
            $success['client'] =  new ClientResource($client);
            $success['token'] =  $client->createToken('client')->accessToken;
            return $this->success($success, 'client loggedin successfully');
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
                return $this->error([],'activation code is wrong');
            }

        }else {
            return $this->error([],'credentials is wrong');
        }
    }

    public function password_recovery(CRequest $request){
        $request->validate([
            "phone" => "required"
        ]);
        $phone = $request->only('phone');
        if ($client = Client::where('phone',$phone)->first()) {
            if(!$client->active){
                return $this->error([],'client not activated');
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
        return $this->error([],'something went wrong');

    }


    public function reset_password(ClientRecoveryRequest $request){
        $phone = $request->only('phone');
        if ($client = Client::where('phone',$phone)->first()) {
            if(!$client->active){
                return $this->error([],'client not activated');
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
                return $this->error([],'code is wrong');
            }
        }
        return $this->error([],'something went wrong');
    }

}
