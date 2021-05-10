<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;


use App\Http\Requests\Payer\PayerLoginRequest;
use App\Http\Requests\Payer\PayerRegisterRequest;
use App\Http\Requests\Payer\PayerActivateRequest;
use App\Http\Requests\Payer\PayerRecoveryRequest;
use App\Models\User;

use App\Http\Resources\PayerResource;

use App\Http\Resources\Notifications\NotificationCollection;
use App\Http\Resources\PayerImagesCollection;
use App\Http\Resources\PayerVideoResource;
use App\Http\Requests\Payer\PayerUpdateDataRequest;
use App\Http\Requests\Payer\PayerUpdateWorkProfileRequest;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Jobs\Admin\PaymentRequestJob;
use Storage;
class UserController extends BaseController
{
    public function payer() {
        $payer = auth()->user();
        // $success['payer'] =  new PayerResource($payer->load('work_video'));
        // $success['token'] =  $payer->createToken('payer')->accessToken;
        return $this->success(new PayerResource($payer->load('work_video')), 'payer data retrived successfully');
    }

    public function register(PayerRegisterRequest $request){
        $image = "";
        if($request->hasFile('imageFile')){
            $image = $request->imageFile->store("/","users");
        }
        $request->request->remove('image');
        $request->merge([
            'active'   => 0,
            'password' => bcrypt($request->password),
            'image'    => $image,
        ]);

        $payer = User::create($request->all());
        $success['payer'] =  new PayerResource($payer);
        $success['token'] =  $payer->createToken('payer')->accessToken;
        return $this->success($success, 'payer registered successfully');
    }



    public function login(PayerLoginRequest $request){
        $credentials = $request->only('phone', 'password');
        if (auth()->attempt($credentials)) {
            $payer = auth()->user();
            // if(!$payer->active){
            //     return $this->error([],'payer not activated');
            // }

            if($request->firebase_token) {
                $payer->update([
                    'firebase_token' => $request->firebase_token
                ]);
            }

            $success['payer'] =  new PayerResource($payer->load(['payer_data','work_images','work_video']));
            $success['token'] =  $payer->createToken('payer')->accessToken;
            return $this->success($success, 'payer loggedin successfully');
        }else{
            return $this->error([],'Check username and password',401);
        }
        return $this->error([],'something went wrong');
    }


    public function activate(PayerActivateRequest $request){
        $credentials = $request->only('phone', 'password');

        if(auth()->attempt($credentials)){
            $payer = auth()->user();
            if($payer->active){
                return $this->error([],'this payer already activated',422);
            }

            // mobile activation logic
            if($request->code == 1111){
                $updated = $payer->update([
                    'active' => 1
                ]);

                if($updated) {
                    $success['payer'] =  new PayerResource($payer);
                    $success['token'] =  $payer->createToken('payer')->accessToken;
                    return $this->success($success, 'account activated successfully');
                }
            }else {
                return $this->error([],'activation code is wrong');
            }

            if($request->firebase_token) {
                $payer->update([
                    'firebase_token' => $request->firebase_token
                ]);
            }


        }else {
            return $this->error([],'Check username and password',401);
        }
    }


    public function updatemyprofile(UserRequest $request)
    {
        $validated = $request->validated();
        $user      = auth()->user();
        if($request->image) {
            Storage::disk('users')->delete($user->image);
            $validated['image'] = $request->image->store("/","users");
        }




        if($user->update($validated)){


            return $this->success(new PayerResource($user),'Profile updated successfully');
        }else {
            return $this->error([],'some thing went wrong');
        }
    }

    public function update_my_data(Request $request)
    {
        $payer = auth()->user();
        $payer->payer_data()->updateOrCreate(["payer_id" => $payer->id],$request->only("job_title","prev_work","bio"));
        
        if($request->prev_work_images) {            
            foreach($payer->work_images as $workimage){
                Storage::disk("work_images")->delete($workimage->image_url);
            }
            $payer->work_images()->delete();
            $images;
            foreach($request->prev_work_images as $prev_work_image) {
                $images[] = ["image_url" => $prev_work_image->store("/","work_images")];
            }
            $payer->work_images()->createMany($images);
        }

        if($request->prev_work_video) {
            if($payer->work_video){
                Storage::disk("work_videos")->delete($payer->work_video->video_url);
            }
            $video = ["video_url" => $request->prev_work_video->store("/","work_videos")];
            $payer->work_video()->updateOrcreate(["payer_id" => $payer->id],$video);
        }
        

        return $this->success(new PayerResource($payer->refresh()->load('payer_data')),'Profile updated successfully');

    }








    public function password_recovery(Request $request){
        $request->validate([
            "phone" => "required"
        ]);
        $phone = $request->only('phone');
        if ($payer = User::where('phone',$phone)->first()) {
            if(!$payer->active){
                return $this->error([],'payer not activated');
            }

            // generete code
            $code = rand(1111,9999);
            $payer->password_recovery()->updateOrCreate([
                "user_type" => "payer"
            ],[
                "code" => $code,
                "user_type" => "payer"
            ]);

            return $this->success(["code" => $code],'Recovery code sent successfully');
        }
        return $this->error([],'phone number not exists');

    }


    public function reset_password(PayerRecoveryRequest $request){
        $phone = $request->only('phone');
        if ($payer = User::where('phone',$phone)->first()) {
            if(!$payer->active){
                return $this->error([],'payer not activated');
            }

            $code = "";
            if($payer->password_recovery){
                $code =  $payer->password_recovery->code;
            } else {
                return $this->error([],'something went wrong',401);
            }


            if($request->code ==  $code ) {
                $payer->update(["password" => bcrypt($request->password)]);
                return $this->success(['reset' => true], 'password rest successfully');
            }else {
                return $this->error([],'code is wrong',401);
            }
        }
        return $this->error([],'phone number not exists');
    }


    public function work_duration()
    {
        return $this->success(['durations' => [
            'hourly','daily','weekly'
        ]], 'Work duration retrived successfully');  
    }


    public function update_firebase_token(Request $requset) {
        $requset->validate([
            'firebase_token' => 'required'
        ]);
        auth()->user()->update([
            'firebase_token' => $requset->firebase_token
        ]);
        return $this->success([], 'firebase token updated successfully');
    }

    public function notifications(){
        // $notifications = [];
        // foreach (auth()->user()->notifications as $key => $notification) {
        //     $notifications[] = load_notification($notification);
        // }
        $notifications = auth()->user()->notifications()->paginate(10);
        return $this->success(new NotificationCollection($notifications), 'Notifications retrived successfully');
    }


    
    public function read_notifications(Request $request){
        if(!$request->notifications_ids) return;
        $notifications = auth()->user()->notifications()->find($request->notifications_ids)->markAsRead();
        return $this->success(null, 'Notifications marked as read');
    }

    public function logout(){
        auth()->user()->tokens()->where('name','payer')->each(function ($token, $key) {
            $token->delete();
        });
        return $this->success([], 'payer logged out successfully');
    }


    public function payer_images(User $user)
    {
        $images = $user->work_images()->paginate(15);
        if(count($images) > 0){
            return $this->success(new PayerImagesCollection($images),'Payer images retrived successfully');
        }
        return $this->success(null,'this user has no images');
    }

    public function payer_video(User $user)
    {
        $video = $user->work_video;
        if($video){
            return $this->success(new PayerVideoResource($video),'Payer video retrived successfully');
        }
        return $this->success(null,'this user has no videos');
    }

    public function update_data(PayerUpdateDataRequest $request) {
        $payer = auth()->user();
        $request_arr = $request->except('image');
        if($request->hasFile('image')){
            Storage::disk('users')->delete($payer->image);
            $image = $request->image->store("/","users");
            $request_arr['image'] = $image;
        }

        if(isset($request->old_password) && !Hash::check($request->old_password,$payer->password)){
            throw new HttpResponseException(
                response()->json([
                  'message' =>'validation errors',
                  'errors'  => ["Old password not correct"]
                ], 422)
              );       
        }


        if(isset($request_arr['password']) && trim($request_arr['password']) != ""){
            $request_arr['password'] = bcrypt($request_arr['password']);
        }

        if($request->full_name) {
            $payer->bank_account_details()->updateOrCreate(["user_id" => $payer->id],$request->only("full_name","bank_name","account_number"));
        }


        $payer->update($request_arr);
        return $this->success([],'payer data updated successfully');
    }


    public function update_work_profile(PayerUpdateWorkProfileRequest $request) {

        $payer = auth()->user();

        if(isset($request->prev_work_remove_images_ids) 
        && !empty($request->prev_work_remove_images_ids)
            ) {
            $work_images = $payer->work_images()->whereIn('id',$request->prev_work_remove_images_ids)->get();
            if($work_images->count() > 0){
                foreach($work_images as $work_image){
                    Storage::disk("work_images")->delete($work_image->image_url);
                }
                $payer->work_images()->whereIn('id',$request->prev_work_remove_images_ids)->delete();
            }
        }


        
        if($request->prev_work_images) { 
            $images;
            foreach($request->prev_work_images as $prev_work_image) {
                $images[] = ["image_url" => $prev_work_image->store("/","work_images")];
            }
            $payer->work_images()->createMany($images);
        }


	if($request->delete_prev_work_video){
        if($payer->work_video){
            Storage::disk("work_videos")->delete($payer->work_video->video_url);
            $payer->work_video()->delete();
        }
	}else{
	
         if($request->prev_work_video) {
            if($payer->work_video){
                Storage::disk("work_videos")->delete($payer->work_video->video_url);
            }
            if($request->hasFile('prev_work_video')) {
                $video = ["video_url" => $request->prev_work_video->store("/","work_videos")];
                $payer->work_video()->updateOrcreate(["payer_id" => $payer->id],$video);
            }
         }

	}


	

        $payer->payer_data()->updateOrCreate(['payer_id'=>$payer->id],$request->validated());

        return $this->success([],'Payer work profile updated successfully');

    }



    public function work_profile_images()
    {
        $images = auth()->user()->work_images()->paginate(15);
        if(count($images) > 0){
            return $this->success(new PayerImagesCollection($images),'Payer images retrived successfully');
        }
        return $this->success(null,'this user has no images');
    }


    public function account_balance(Request $request){
        $wallet = auth()->user()->wallet;
        $balance = [
            'total_price' => 0,
            'total_fees' => 0,
            'total_amount' => 0,
    ];
        if($wallet) {
            $balance = [
                'total_price' => $wallet->total_price,
                'total_fees' => $wallet->total_fees,
                'total_amount' => $wallet->total_amount,
            ];
        }
        return $this->success(['balance' => $balance],'Account balance retrived successfully');
    }

    public function payment_request(Request $request){
        $user   = auth()->user();
        $wallet = auth()->user()->wallet;

        if(!$wallet){
            return $this->error([],'Sorry you don\'t have any balance to request payment'); 
        }

        $bank_account_details = auth()->user()->bank_account_details;

        if(!$bank_account_details) {
            return $this->error([],'Please insert your bank account details and try again'); 
        }
        $payment_request = $user->payment_requests()->where('status','unpaid')->first();

        if($payment_request) {
            return $this->error([],'You already have payment request'); 
        }
        $new_payment_request = $user->payment_requests()->create([
            'wallet_id' => $wallet->id
        ]);

        if($new_payment_request){
            PaymentRequestJob::dispatch($new_payment_request);

            return $this->success([],'Payment request created');
        }

    }

}
