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

use Storage;
class UserController extends BaseController
{
    public function payer() {
        return $this->success(new PayerResource(auth()->user()), 'payer data retrived successfully');
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
        return $this->success(new PayerResource($payer), 'payer registered successfully');
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
        return $this->error([],'something went wrong');

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
        return $this->error([],'something went wrong');
    }


    public function work_duration()
    {
        return $this->success(['durations' => [
            'hourly','daily','weekly'
        ]], 'Work duration retrived successfully');  
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

}
