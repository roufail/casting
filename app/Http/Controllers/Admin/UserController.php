<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Service;
Use Alert,Storage;
use App\Http\Requests\Admin\User\UserRequest;


class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $services = Service::get(['id','title']);
        return view('admin.users.form',compact('user','services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        if($request->image) {
            $validated['image'] = $request->image->store("/","users");
        }


 

        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }
        $validated['password'] = bcrypt($validated['password']);


        if($user = User::create($validated)){
            $user->services()->delete();
            $user->services()->createMany($validated['services']);

            foreach ($validated['services'] as $service) {
                
            }


            if($request->work_images) {
                foreach ($request->work_images as $image) {
                    $user->work_images()->create(['image_url' => $image]);
                };
            }


            if($request->work_video) {
                $user->work_video()->create(['video_url' => $request->work_video]);
            }

            $user->payer_data()->create([
                'job_title'             => $request->job_title,
                'prev_work'             => $request->prev_work,
                'bio'                   => $request->bio,    
            ]);
            
            Alert::toast('<h4>تم انشاء المستخدم بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $services = Service::get(['id','title']);
        $user->load(['services','work_images','work_video']);
        return view('admin.users.form',compact('user','services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();
        unset($validated['password_confirmation']);

        if($request->image) {
            Storage::disk('users')->delete($user->image);
            $validated['image'] = $request->image->store("/","users");
        }
        if($validated['password'] == null)
        {
            unset($validated['password']);
        }else{
            $validated['password'] = bcrypt($validated['password']);
        }

        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }

        if($user->update($validated)){

            $created_services = [];
            foreach ($validated['services'] as $service) {
                $created_services[] = $user->services()->updateOrCreate([
                    'service_id' => $service['service_id']
                ],$service);
            }

            $user->services()->whereNotin('id',collect($created_services)->pluck('id')->toArray())->delete();

            $user->work_images()->delete();
            $user->work_video()->delete();

            if($request->work_images) {
                foreach ($request->work_images as $image) {
                    $user->work_images()->create(['image_url' => $image]);
                };
            }

            if($request->work_video) {
                $user->work_video()->create(['video_url' => $request->work_video]);
            }


            $user->payer_data()->updateOrCreate(['payer_id' => $user->id],[
                'job_title'             => $request->job_title,
                'prev_work'             => $request->prev_work,
                'bio'                   => $request->bio,    
            ]);

            Alert::toast('<h4>تم تحديث المستخدم بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        Storage::disk('users')->delete($user->image);
        if($user->delete()){
            Alert::toast('<h4>تم حذف المستخدم بنجاح</h4>','success');
            return redirect(route('admin.users.index'));
        }
        Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        return redirect(route('admin.users.index'));
    }



    public function ajaxData()
    {
        return Datatables::of(User::query())
        ->addColumn('image', function ($user) {
            if($user->image && $user->image != ""){
                return '<img src="'.\Storage::disk("users")->url($user->image).'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            }else {
                return '<img src="'.url("imgs/no-user.png").'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            } 
        })->addColumn('action', function ($user) {
            return '
            <a  style="float:right" href="'.route('admin.users.edit',$user->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.__('admin/users.list.edit').'</a>
            <form method="post" action="'.route('admin.users.destroy',$user->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>'.__('admin/users.list.delete').'</a>
             </form>';
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }

    public function delete_image(Request $request) {
        if($request->ajax()){
            $user = User::findOrFail($request->id);
            Storage::disk('users')->delete($user->image);
            $user->update(['image' => null]);
            return true;
        }
    }

    public function delete_video(Request $request) {
        if($request->ajax()){
            $user = User::findOrFail($request->id);
            Storage::disk('work_videos')->delete($user->work_video->video_url);
            $user->work_video()->delete();;
            return true;
        }
    }



    



    public function upload_images(Request $request) {
        if($request->ajax()){
            $name = $request->file->store("/","work_images");
            return response()->json([
            'url'  => Storage::disk('work_images')->url($name),
            'name' => $name
            ]);
        }
    }

    public function remove_dropzone_image(Request $request) {
        $image_arr = explode("/",$request->image);
        $image     = end($image_arr);
        Storage::disk('work_images')->delete($image);
        return response()->json(['success' => true,'name' => $image]);
    }


    public function upload_video(Request $request){
        if($request->ajax()){
            $name = $request->video->store("/","work_videos");
            return response()->json([
            'url'  => Storage::disk('work_videos')->url($name),
            'name' => $name
            ]);
        }

    }


}
