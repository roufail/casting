<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\UserService;
use App\Models\Rate;
use App\Models\Outgoing;
use App\Models\Setting;

use App\Http\Requests\Order\OrderRequest;
use App\Jobs\Payer\ServiceRequestJob;
use App\Jobs\Client\OrderStatusUpdateJob;
use App\Jobs\Admin\AdminPaymentJob;
use App\Http\Requests\Api\RateRequest;

class OrderController extends BaseController
{
    private $status_ar = ['paid', 'processing', 'cancelled', 'done','pending','failed','received'];
    public function myorders($status=null){

        $orders = auth()->user()->orders()->with('client:id,name','user:id,name','userservice.service');

        if($status){
            $orders = $orders->where('status' , $status);
        }

        $orders = $orders->latest()->paginate(15);
        return  $this->success(new OrderCollection($orders),'Orders Retrived Successfully');
    }


    public function payer_order($order){
        $order = auth()->user()->orders()->find($order);
        if(!$order){
           return $this->success([],'Order dosn\'t exits',404);
        }
        return  $this->success(new OrderResource($order),'Order Retrived Successfully');
    }



    public function payer_updatemyorders($id,$status) {
        $order = auth()->user()->orders()->find($id);
        if($status > 3) {
            return  $this->error([],'invalid order status');
        }
        if($order && in_array($this->status_ar[$status],['processing','cancelled','done'])) {
            $order->update(['status' => $this->status_ar[$status]]);
            OrderStatusUpdateJob::dispatch($order);
            return  $this->success($order,'Order updated successfully');
        }else {
            return  $this->error([],'invalid order status');
        }
    }


    public function place_order(OrderRequest $request){
        $userService = UserService::findOrFail($request->payer_service_id);

        // make payment 
        $order = auth('client-api')->user()->orders()->create([
                'user_id'         => $userService->user_id,
                'service_id'      => $userService->service_id,
                'user_service_id' => $userService->id,
                "status"          => 'pending',
                "price"           => $userService->price,
        ]);
       

        // pay to website
        $payment = true;

        if($payment){    

           $order->incoming()->create([
                'received' => 1,
                'delivered' => 0
            ]);


            $updated = $order->update([
                'status' => 'paid'
            ]);

 

           
            if($updated){
                AdminPaymentJob::dispatch($order);
                ServiceRequestJob::dispatch(auth('client-api')->user(),$userService->user,$userService->service);
            }


            return  $this->success(new OrderResource($order),'Order created successfully');
        } else {
            $order->update([
                'status' => 'faild'
            ]);
            return  $this->error([],'payment faild');
        }


    }



    public function client_updatemyorders($id,$status) {
        $order = auth('client-api')->user()->orders()->find($id);
        if($order && in_array($this->status_ar[$status],['done'])) {
            $order->update(['status' => $status]);
            $order->load('incoming');
            OrderStatusUpdateJob::dispatch($order);

            $settings = Setting::pluck('setting_value','setting_key')->toArray();
            $fees = (($order->price * $settings['percentage']) / 100);
            Outgoing::updateOrCreate(['order_id' => $order->id],[
                'order_id'    => $order->id,
                'incoming_id' => $order->incoming->id,
                'fees'        => $fees,
                'total'       => $order->price - $fees
            ]);
            // send notification to the admin
            return  $this->success($order,'Order updated successfully');
        }else {
            return  $this->error([],'Clinet can set order to done [3] only ');
        }
    }


    public function client_orders() {
        $orders = auth('client-api')->user()->orders()->with(["userservice","user"])->paginate(10);
        return  $this->success(new OrderCollection($orders),'orders retrived successfully');
    }

    public function client_order($id) {
        $order = auth('client-api')->user()->orders()->with(["userservice","user",'userservice.service'])->find($id);
        return  $this->success(new OrderResource($order),'order retrived successfully');
    }


    public function rate_payer(RateRequest $request,$order) {
        $order = auth('client-api')->user()->orders()->where('status','done')->where('id',$order)->first();
        if($order) {
            $rate = Rate::create([
                'service_id'      => $order->service_id,
                'user_service_id' => $order->user_service_id,
                'client_id'       => $order->client_id,
                'rate'            => $request->rate,
                'feedback'        => $request->feedback,
            ]);
            return  $this->success($rate,'Rate created successfully');
        }else{
            return  $this->error([],'Something went wrong');
        }
    }


}
