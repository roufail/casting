<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth('admin')->user()->notifications()->paginate(20);
        return view('admin.notifications.index',compact('notifications'));
    }


}
