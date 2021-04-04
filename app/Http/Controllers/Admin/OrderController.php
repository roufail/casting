<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orders.index');
    }

    public function chat(Order $order) {
        $order->load('chat.messages');
        return view('admin.orders.chat',compact('order'));
    }

    public function ajaxData()
    {
        $orders = Order::query();
        return DataTables::of($orders)
        ->addColumn('service', function ($order) {
            return $order->userservice->service ? $order->userservice->service->title : '------';
        })
        ->addColumn('user', function ($order) {
            return $order->user ? $order->user->name : '------';
        })
        ->addColumn('client', function ($order) {
            return $order->client ? $order->client->name : '------';
        })
        ->addColumn('chat', function ($order) {
            return $order->chat ? '<a href="'.route('admin.orders.chat',$order->id).'" class="btn"><i class="fa fa-comments"></i></a>' : '';
        })
        ->rawColumns(['image', 'action','chat'])
        ->make(true);
    }
}
