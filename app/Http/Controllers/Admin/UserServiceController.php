<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\UserService\UserServiceRequest;
use App\Models\User;
use App\Models\Service;
use App\Models\UserService;
use Yajra\Datatables\Datatables;
Use Alert,Storage;

class UserServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.userservices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(UserService $userservice)
    {
        $users    = User::pluck('name','id');
        $services = Service::pluck('title','id');
        return view('admin.userservices.form',compact('users','services','userservice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserServiceRequest $request)
    {
        $validated = $request->validated();
        $validated['active'] = 0;
        $validated['category_id'] = Service::findOrFail($validated['service_id'])->id;
        if($request->exists('active')){
            $validated['active'] = 1;
        }
        if(UserService::create($validated)){
            Alert::toast('<h4>تم اضافة الخدمة بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->route("admin.userservices.index");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserService $userservice)
    {
        $users    = User::pluck('name','id');
        $services = Service::pluck('title','id');
        return view('admin.userservices.form',compact('services','userservice','users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserServiceRequest $request, UserService $userservice)
    {

        $validated = $request->validated();
        $validated['active'] = 0;
        if($request->exists('active')){
            $validated['active'] = 1;
        }
        if($userservice->update($validated)){
            Alert::toast('<h4>تم تحديث الخدمة بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function ajaxData()
    {
        return Datatables::of(UserService::with(['service']))
        ->addColumn('image', function ($userservice) {
            if($userservice->image && $userservice->image != ""){
                return '<img src="'.\Storage::disk("userservices")->url($userservice->image).'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            }else {
                return '<img src="'.url("imgs/no-user.png").'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            } 
        })
        ->addColumn('action', function ($userservice) {
            return '
            <a  style="float:right" href="'.route('admin.userservices.edit',$userservice->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> تعديل</a>
            <form method="post" action="'.route('admin.userservices.destroy',$userservice->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> حذف</a>
             </form>';
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }

}
