<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Admin\Admin\AdminRequest;
use Alert;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admins.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Admin $admin)
    {
        return view('admin.admins.form',compact('admin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {

        $validated = $request->validated();
        if(Admin::create($validated)){
            Alert::toast('<h4>تم انشاء المدير بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->route('admin.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.form',compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {

        $validated = $request->validated();        
        
        unset($validated['password_confirmation']);

        if($validated['password'] == null)
        {
            unset($validated['password']);
        }else{
            $validated['password'] = bcrypt($validated['password']);
        }


        if($admin->update($validated)){
            Alert::toast('<h4>تم تحديث المدير بنجاح</h4>','success');
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
    public function destroy($id)
    {
        //
    }

    public function ajaxData() {
        return Datatables::of(Admin::query())

        ->addColumn('action', function ($admin) {
            $action = '<a  style="float:right" href="'.route('admin.admins.edit',$admin->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.__('admin/admins.list.edit').'</a>';
            
            if($admin->id != 1 && $admin->id != auth('admin')->user()->id) {
             $action .='<form method="post" action="'.route('admin.admins.destroy',$admin->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i>'.__('admin/admins.list.delete').'</a>
             </form>';
            }

            return $action;


        })
        ->make(true);
    }
}
