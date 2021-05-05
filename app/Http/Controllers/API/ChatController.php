<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Models\Chat;
use App\Models\Order;
use App\Events\Message;
use Google\Cloud\Firestore\FirestoreClient;

use App\Http\Resources\Chat\ChatResource;

use Storage;
class ChatController extends BaseController
{
    private $db,$collection;

    function __construct() {

        $this->db  = new FirestoreClient([
            'projectId' => 'casting-fb0d5',
            'keyFile' => json_decode(file_get_contents(base_path('casting-firestore.json')), true)
        ]);

        $this->collection = $this->db->collection('Orders');




    }
    public function message_to_client(Request $request , $order){
        $request->validate([
            'message' => 'required',
            'message_type' => 'required|string|in:text,image',
        ]);

        $order = Order::find($order);
        
        if(!$order){
            return $this->error([],'somthing went wrong!');
        }



	 $chat = Chat::firstOrCreate([
		'order_id'  => $order->id,		
		'user_id'  => auth()->user()->id,
	],[
            'order_id'  => $order->id,
            'user_id'   => auth()->user()->id,
            'client_id' => $order->client_id
        ]);

        if($request->message_type == "image" && $request->hasFile('message')) {
            $request->message = Storage::disk('messages')->url($request->message->store("/","messages"));
        }else {
            $request->message_type = "text";
        }

        $message_data = [
            'user_id'      =>  auth()->user()->id,
            'user_type'    => 'payer',
            'message'      =>  $request->message,
            'message_type' =>  $request->message_type,
        ];


        
        
        $message = $chat->messages()->create($message_data);

        $payer = User::find(auth()->user()->id);

        $message_data = array_merge($message_data,[
            'time'   => \Carbon\Carbon::now(),
            'order_id'=> $order->id,
            'payer' => [
                "id"        => $payer->id,
                "name"      => $payer->name,
                "image"     => $payer->image && $payer->image != "" ? Storage::disk("users")->url($payer->image) : null,
            ]
        ]); 
        
        
        $this->collection->document($order->id)->collection('chat')->document($this->milliseconds())->set($message_data);
        broadcast(new Message($order->client_id,$message_data,$order->id,'client'));

        $response = [
            "message"       => $request->message,
            "message_type"  => $request->message_type,
            "order_id"      => $order->id,
            "sender_avatar" => auth()->user()->image && auth()->user()->image != "" ? Storage::disk("users")->url(auth()->user()->image): null,
            "sender_type"   => 'payer',
            "created_at"    => $message->created_at,
        ];
        // fire the event

        return $this->success($response, 'message send successfully');
    }


    public function milliseconds() {
        $mt = explode(' ', microtime());
        return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
    }
    

    public function message_to_payer(Request $request , $order){
        $request->validate([
            'message' => 'required',
            'message_type' => 'required|string|in:text,image',
        ]);
        $order = Order::find($order);

        if(!$order){
            return $this->error([],'somthing went wrong!');
        }



        $chat = Chat::firstOrCreate([
		'order_id'  => $order->id,		
		'client_id'  => auth("client-api")->user()->id,
	],[
            'order_id'  => $order->id,
            'user_id'   => $order->user_id,
            'client_id' => auth("client-api")->user()->id
        ]);

	


        if($request->message_type == "image" && $request->hasFile('message')) {
            $request->message = Storage::disk('messages')->url($request->message->store("/","messages"));
        }else {
            $request->message_type = "text";
        }

        $message_data = [
            'user_id'      =>  auth('client-api')->user()->id,
            'user_type'    => 'client',
            'message'      =>  $request->message,
            'message_type' =>  $request->message_type,
        ];

        $message = $chat->messages()->create($message_data);
        $client = Client::find(auth('client-api')->user()->id);

        $message_data = array_merge($message_data,[
            'order_id'=> $order->id,
            'time'   => \Carbon\Carbon::now(),
            'client' => [
                "id"        => $client->id,
                "name"      => $client->name,
                "image"     => $client->image && $client->image != "" ? Storage::disk("clients")->url($client->image) : null,
            ]
        ]);   
        $this->collection->document($order->id)->collection('chat')->document($this->milliseconds())->set($message_data);

        // fire the event
        broadcast(new Message($order->user_id,$message_data,$order->id,'payer'));
        $response = [
            "message"       => $request->message,
            "message_type"  => $request->message_type,
            "order_id"      => $order->id,
            "sender_avatar" => auth("client-api")->user()->image && auth("client-api")->user()->image != "" ? Storage::disk("clients")->url(auth()->user()->image): null,
            "sender_type"   => 'client',
            "created_at"    => $message->created_at,
        ];

        return $this->success($response, 'message send successfully');    
    }


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
