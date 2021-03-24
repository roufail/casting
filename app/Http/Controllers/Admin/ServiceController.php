<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
Use Alert,Storage;
use App\Http\Requests\Admin\Service\ServiceRequest;



class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Service $service)
    {
        $categories = Category::pluck('title','id');
        return view('admin.services.form',compact('service','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        if($request->image) {
            $validated['image'] = $request->image->store("/","services");
        }

        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }

        if(Service::create($validated)){
            Alert::toast('<h4>تم انشاء الخدمه بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->route('admin.services.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $categories = Category::pluck('title','id');
        return view('admin.services.form',compact('service','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();
        if($request->image) {
            Storage::disk('services')->delete($service->image);
            $validated['image'] = $request->image->store("/","services");
        }
 
        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }


        if($service->update($validated)){
            Alert::toast('<h4>تم تحديث الخدمة بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        Storage::disk('services')->delete($service->image);
        if($service->delete()){
            Alert::toast('<h4>تم حذف الخدمه بنجاح</h4>','success');
            return redirect(route('admin.services.index'));
        }
        Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        return redirect(route('admin.services.index'));
    }



    public function ajaxData()
    {
        return Datatables::of(Service::query())
        ->addColumn('image', function ($service) {
            if($service->image && $service->image != ""){
                return '<img src="'.\Storage::disk("services")->url($service->image).'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            }else {
                return '<img src="'.url("imgs/no-user.png").'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            } 
        })
        ->addColumn('category', function ($service) {
            return $service->category->title;
        })
        ->addColumn('action', function ($service) {
            return '
            <a  style="float:right" href="'.route('admin.services.edit',$service->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> '.__("admin/services.list.edit").'</a>
            <form method="post" action="'.route('admin.services.destroy',$service->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> '.__("admin/services.list.delete").'</a>
             </form>';
        })
        ->rawColumns(['image', 'action'])
        ->make(true);
    }


    public function delete_image(Request $request) {
        if($request->ajax()){
            $service = Service::findOrFail($request->id);
            Storage::disk('services')->delete($service->image);
            $service->update(['image' => null]);
            return true;
        }
    }


}
