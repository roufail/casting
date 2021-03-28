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

use Storage;
class UserController extends BaseController
{
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
        return $this->success(new PayerResource($payer), 'payer loggedin successfully');
    }



    public function login(PayerLoginRequest $request){
        $credentials = $request->only('phone', 'password');
        if (auth()->attempt($credentials)) {
            $payer = auth()->user();
            if(!$payer->active){
                return $this->error([],'payer not activated');
            }
            $success['payer'] =  new PayerResource($payer->load(['payer_data','work_images','work_video']));
            $success['token'] =  $payer->createToken('payer')->accessToken;
            return $this->success($success, 'payer loggedin successfully');
        }
        return $this->error([],'something went wrong');
    }


    public function activate(PayerActivateRequest $request){
        $credentials = $request->only('phone', 'password');

        if(auth()->attempt($credentials)){
            $payer = auth()->user();
            if($payer->active){
                return $this->error([],'this payer already activated');
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

        }else {
            return $this->error([],'credentials is wrong');
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
            Storage::disk("work_videos")->delete($payer->work_video->video_url);
            $video = ["video_url" => $prev_work_image->store("/","work_videos")];
            $payer->work_video()->updateOrcreate(["payer_id" => $payer->id],$video);
        }
    }




    public function password_recovery(PayerRecoveryRequest $request){
        $phone = $request->only('phone');
        if ($payer = User::where('phone',$phone)->first()) {
            if(!$payer->active){
                return $this->error([],'payer not activated');
            }

            if($request->code == 1111) {
                $payer->update(["password" => bcrypt($request->password)]);
                return $this->success(['reset' => true], 'password rest successfully');
            }else {
                return $this->error([],'code is wrong');
            }


            
        }
        return $this->error([],'something went wrong');

    }




}
