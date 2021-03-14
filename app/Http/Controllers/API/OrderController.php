<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Resources\Order\OrderCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\UserService;

use App\Http\Requests\Order\OrderRequest;
use App\Jobs\Payer\ServiceRequestJob;
use App\Jobs\Client\OrderStatusUpdateJob;
use App\Jobs\Admin\AdminPaymentJob;
class OrderController extends BaseController
{
    public function myorders($status=null){
        $orders = auth()->user()->orders()->with('client:id,name','user:id,name','userservice.service');
        if($status){
            $orders = $orders->where('status' , $status);
        }
        $orders = $orders->paginate(10);
        return  $this->success(new OrderCollection($orders),'Orders Retrived Successfully');
    }

    public function updatemyorders($id,$status) {
        $order = auth()->user()->orders()->find($id);
        if($order && in_array($status,get_status())) {
            $order->update(['status' => $status]);
            // send notification to the customer
            // your order [] status changed to []  by []
            OrderStatusUpdateJob::dispatch($order);
            return  $this->success($order,'Order updated successfully');
        }else {
            return  $this->error([],'Something went wrong');
        }
    }


    public function place_order(OrderRequest $request){
        $userService = UserService::findOrFail($request->user_service_id);

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
            
            
            

            
                $updated = $order->update([
                    'status' => 'paid'
                ]);
                
                if($updated){
                    
                // send notification to the the site
                AdminPaymentJob::dispatch($order);

                // send notification to the payer
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
}
