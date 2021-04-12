<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rate;
use Yajra\Datatables\Datatables;
use Alert;
class RatingController extends Controller
{
    public function index(){
        return view('admin.ratings.index');
    }

    public function destroy($rate) {
        $rate = Rate::findOrFail($rate);
        if($rate->delete()){
            Alert::toast('<h4>تم حذف التقييم بنجاح</h4>','success');
            return redirect(route('admin.ratings.index'));
        }
        Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        return redirect(route('admin.ratings.index'));

    }



    public function ajaxData()
    {
        $ratings = Rate::with('service','userservice.user','client');
        return DataTables::of($ratings)
        ->addColumn('userservice.user.name', function ($rating) {
            return $rating->userservice && $rating->userservice->user ? $rating->userservice->user->name : '-----';
        })
        ->addColumn('client.name', function ($rating) {
            return $rating->client ? $rating->client->name  : '-----';
        })
        ->addColumn('action', function ($rating) {
            return '
            <form method="post" action="'.route('admin.ratings.destroy',$rating->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> '.__("admin/ratings.list.delete").'</a>
             </form>';
        })->make(true);
    }
}
