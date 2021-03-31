<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Chat;
use App\Models\Order;
use App\Events\Message;


use App\Http\Resources\Chat\ChatResource;

use Storage;
class ChatController extends BaseController
{
    public function message_to_client(Request $request , $order){
        $request->validate([
            'message' => 'required|string',
            'message_type' => 'required|string',
        ]);

        $order = Order::find($order);
        if(!$order){
            return $this->error([],'somthing went wrong!');
        }

        $chat = Chat::firstOrCreate([
         'order_id' => $order->id
        ],[
            'order_id'  => $order->id,
            'user_id'   => auth()->user()->id,
            'client_id' => $order->client_id
        ]);

        $message = $chat->messages()->create([
            'user_id'      =>  auth()->user()->id,
            'user_type'    => 'payer',
            'message'      =>  $request->message,
            'message_type' =>  $request->message_type,
        ]);

        // fire the event
        broadcast(new Message($order->client_id,$request->message,$order->id,'client'));
        $response = [
            "message"       => $request->message,
            "message_type"  => $request->message_type,
            "order_id"      => $order->id,
            "sender_avatar" => auth()->user()->image && auth()->user()->image != "" ? Storage::disk("users")->url(auth()->user()->image): null,
            "sender_type"   => 'payer',
            "created_at"    => $message->created_at,
        ];

        return $this->success($response, 'message send successfully');
    }

    public function message_to_payer(Request $request , $order){
        $request->validate([
            'message' => 'required|string',
            'message_type' => 'required|string',
        ]);
        $order = Order::find($order);
        if(!$order){
            return $this->error([],'somthing went wrong!');
        }

        $chat = Chat::firstOrCreate([
         'order_id' => $order->id
        ],[
            'order_id'  => $order->id,
            'user_id'   => auth()->user()->id,
            'client_id' => $order->client_id
        ]);

        $message = $chat->messages()->create([
            'user_id'      =>  auth()->user()->id,
            'user_type'    => 'client',
            'message'      =>  $request->message,
            'message_type' =>  $request->message_type,
        ]);

        // fire the event
        broadcast(new Message($order->client_id,$request->message,$order->id,'payer'));
        $response = [
            "message"       => $request->message,
            "message_type"  => $request->message_type,
            "order_id"      => $order->id,
            "sender_avatar" => auth("client-api")->user()->image && auth("client-api")->user()->image != "" ? Storage::disk("clients")->url(auth()->user()->image): null,
            "sender_type"   => 'client',
            "created_at"    => $message->created_at,
        ];

        return $this->success($response, 'message send successfully');    }

    public function load_chat($order){
        $chat = Chat::where("order_id",$order)->first();
        if(!$chat){
            return $this->error([],'somthing went wrong!');
        }
        $chat->load_messages = true;
        return $this->success(new ChatResource($chat), 'chat loaded successfully');
    }

    public function test_socket() {
        $socket = stream_socket_client('tcp://127.0.0.1:4444');
        if ($socket) {
            $sent = stream_socket_sendto($socket, 'message');
            if ($sent > 0) {
                $server_response = fread($socket, 4096);
                echo $server_response;
            }
        } else {
            echo 'Unable to connect to server';
        }
        stream_socket_shutdown($socket, STREAM_SHUT_RDWR);
        
    }


}
