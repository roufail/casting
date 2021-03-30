<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('welcome');
    }


    public function privacy_policy()
    {
        return Session::get("settings")['privacy_policy'];
    }

    public function terms_and_conditions()
    {
        return Session::get("settings")['terms_and_conditions'];
    }
}
