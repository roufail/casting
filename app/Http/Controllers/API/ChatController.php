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

//use Benwilkins\FCM\FcmMessage;

use Storage,Auth;
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
            'message_type' => 'required|string|in:text,image,audio',
        ]);

        $order = Order::find($order);
        
        if(!$order || $order->user_id != auth()->user()->id){
            return $this->error([],'Permission denied!');
        }



	 $chat = Chat::firstOrCreate([
		'order_id'  => $order->id,		
		'user_id'  => auth()->user()->id,
	],[
            'order_id'  => $order->id,
            'user_id'   => auth()->user()->id,
            'client_id' => $order->client_id
        ]);

        if(($request->message_type == "image" || $request->message_type == "audio") && $request->hasFile('message')) {
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

        $firebase_token = $order->user->firebase_token;
        if($firebase_token){
            $fb_message_data = [
                'title'          => $payer->name."@ order".$order->id,
                'body'           => $request->message,
                'order_id'       => $order->id,
                'firebase_token' => $firebase_token,
            ];
            $this->sendMessageNotification($fb_message_data);
        }

        return $this->success($message_data, 'message send successfully');
    }


    public function milliseconds() {
        $mt = explode(' ', microtime());
        return ((int)$mt[1]) * 1000 + ((int)round($mt[0] * 1000));
    }
    

    public function message_to_payer(Request $request , $order){
        $request->validate([
            'message' => 'required',
            'message_type' => 'required|string|in:text,image,audio',
        ]);
        $order = Order::find($order);

        if(!$order || $order->client_id != auth("client-api")->user()->id){
            return $this->error([],'Permission denied!');
        }



        $chat = Chat::firstOrCreate([
		'order_id'  => $order->id,		
		'client_id'  => auth("client-api")->user()->id,
	        ],[
            'order_id'  => $order->id,
            'user_id'   => $order->user_id,
            'client_id' => auth("client-api")->user()->id
        ]);

	


        if(($request->message_type == "image" || $request->message_type == "audio") && $request->hasFile('message')) {
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
        
        $firebase_token = $order->user->firebase_token;
        if($firebase_token){
            $fb_message_data = [
                'title'          => $client->name."@ order".$order->id,
                'body'           => $request->message,
                'order_id'       => $order->id,
                'firebase_token' => $firebase_token,
            ];
            $this->sendMessageNotification($fb_message_data);
        }

        return $this->success($message_data, 'message send successfully');    
    }


    public function load_chat($order_id){
        $user_type   = Auth::getDefaultDriver();
        $order       = Order::find($order_id);
        $logged_user = auth($user_type)->user();
        if( ($user_type == "payer-api" && $order->user_id != $logged_user->id) || ($user_type == "client-api" && $order->client_id != $logged_user->id) ){
            return $this->error([],'Permission denied!');
        }
        
        $chat = Chat::where("order_id",$order_id)->first();
        if(!$chat){
            $chat = $order->chat()->create([
                'user_id' => $order->user_id,
                'client_id' => $order->client_id,
            ]);
        }
        $chat->load_messages = true;
        return $this->success(new ChatResource($chat), 'chat loaded successfully');
    }


    public function sendMessageNotification($message_data){
        // $message = new FcmMessage();
        // $message->content([
        //     'title'        => $message_data['title'], 
        //     'body'         => $message_data['body'], 
        // ])->data([
        //     'order_id'     => $message_data['order_id'] // Optional
        // ])->to($message_data['firebase_token']); // Optional - Default is 'normal'.
        // return $message;    


        $SERVER_API_KEY = env('FCM_SECRET_KEY');
  
        $data = [
            "registration_ids" => array($message_data['firebase_token']),
            "notification" => [
                "title" => $message_data['title'],
                "body" =>$message_data['body'],  
            ]
        ];
        $dataString = json_encode($data);
    
        $headers = [
            'Authorization' => 'key='.$SERVER_API_KEY,
            'Content-Type'  => 'application/json',
        ];
    	




        $client = new \GuzzleHttp\Client();
        $request = $client->post('https://fcm.googleapis.com/fcm/send',[
            'headers' => $headers,
            "body" => $dataString,
        ]);
        $response = $request->getBody();

    }




}
