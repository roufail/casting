<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
Use Alert,Storage;
use App\Http\Requests\Admin\Category\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        return view('admin.categories.form',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.form',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        if($request->image) {
            Storage::disk('categories')->delete($category->image);
            $validated['image'] = $request->image->store("/","categories");
        }
 
        if($request->active) {
            $validated['active'] = true;
        }else {
            $validated['active'] = false;
        }


        if($category->update($validated)){
            Alert::toast('<h4>تم تحديث الخدمة بنجاح</h4>','success');
        }else{
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        Storage::disk('categories')->delete($category->image);
        if($category->delete()){
            Alert::toast('<h4>تم حذف الخدمه بنجاح</h4>','success');
            return redirect(route('admin.categories.index'));
        }
        Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        return redirect(route('admin.categories.index'));    
    }


    public function ajaxData()
    {
        return Datatables::of(Category::query())
        ->addColumn('image', function ($category) {
            if($category->image && $category->image != ""){
                return '<img src="'.\Storage::disk("categories")->url($category->image).'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            }else {
                return '<img src="'.url("imgs/no-user.png").'" border="0" width="100px" height="100px" class="img-rounded" align="center" />';
            } 
        })->addColumn('action', function ($category) {
            return '
            <a  style="float:right" href="'.route('admin.categories.edit',$category->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> تعديل</a>
            <form method="post" action="'.route('admin.categories.destroy',$category->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> حذف</a>
             </form>';
        })
        ->make(true);
    }


    public function delete_image(Request $request) {
        if($request->ajax()){
            $service = Category::findOrFail($request->id);
            Storage::disk('categories')->delete($service->image);
            $service->update(['image' => null]);
            return true;
        }
    }

}
