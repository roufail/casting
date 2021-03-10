<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class BaseController extends Controller
{
    public function success($data,$message){
        $response = [
            'response' => $data,
            'message'  => $message
        ];
        return response()->json($response,200);
    }



    public function error($data,$message,$code=500){
    	$response = [
            'success' => false,
            'message' => $message,
        ];
        if(!empty($data)){
            $response['response'] = $data;
        }
        return response()->json($response, $code);
    }
}
