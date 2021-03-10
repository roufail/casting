<?php

namespace App\Http\Controllers\Admin;

use App\Models\Incoming;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.incomings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function show(Incoming $incoming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function edit(Incoming $incoming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incoming $incoming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incoming $incoming)
    {
        //
    }



    public function ajaxData()
    {
        $incomings = Incoming::with('order.userservice.service','order.client','order.user');
        return DataTables::of($incomings)
        ->addColumn('service', function ($incomings) {
            return $incomings->order->userservice->service ? $incomings->order->userservice->service->title : '------';
        })
        ->addColumn('user', function ($incomings) {
            return $incomings->order->user ? $incomings->order->user->name : '------';
        })
        ->addColumn('client', function ($incomings) {
            return $incomings->order->client ? $incomings->order->client->name : '------';
        })
        ->addColumn('price', function ($incomings) {
            return $incomings->order ? $incomings->order->price : '------';
        })
        ->addColumn('status', function ($incomings) {
            return $incomings->order ? $incomings->order->status : '------';
        })
        ->addColumn('received', function ($incomings) {
            return $incomings->received ? 'نعم' : 'لا';
        })
        ->addColumn('delivered', function ($incomings) {
            return $incomings->delivered ? 'نعم' : 'لا';
        })
        ->addColumn('action', function ($category) {
            return '
            <a  style="float:right" href="'.route('admin.categories.edit',$category->id).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> تعديل</a>
            <form method="post" action="'.route('admin.categories.destroy',$category->id).'">
             '.csrf_field().method_field("delete").'
             <button style="float:right" type="submit" class="delete-record btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> حذف</a>
             </form>';
        })->make(true);
    }

}
