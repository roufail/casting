<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\Client\ClientLoginRequest;
use App\Http\Requests\Client\ClientRegisterRequest;
use App\Models\Client;
class ClientController extends BaseController
{

    public function register(ClientRegisterRequest $request){
        $image = "";
        if($request->hasFile('imageFile')){
            $image = $request->imageFile->store("/","clients");
        }
        $request->request->remove('image');
        $request->merge([
            'active'   => 0,
            'password' => bcrypt($request->password),
            'image'    => $image,
        ]);

        $client = Client::create($request->all());
        return $this->success($client, 'client loggedin successfully');
    }



    public function login(ClientLoginRequest $request){
        $credentials = $request->only('email', 'password');
        if (auth('client')->attempt($credentials)) {
            $client = auth('client')->user();
            $success['token'] =  $client->createToken('client')->accessToken;
            return $this->success($success, 'client loggedin successfully');
        }
        return $this->error([],'something went wrong');
    }
}
