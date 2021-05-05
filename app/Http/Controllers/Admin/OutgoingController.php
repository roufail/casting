<?php

namespace App\Http\Controllers\Admin;

use App\Models\Outgoing;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
Use Alert;

// use TapPayments\GoSell;

class OutgoingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.outgoings.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Incoming  $incoming
     * @return \Illuminate\Http\Response
    */
    public function show(Outgoing $outgoing)
    {
        //
    }


    public function pay(Order $order)
    {
        // make payment request
        $payment = true;
        // GoSell::setPrivateKey("sk_test_DecgsiEPGZFfrNRwYt2hWxvK");

        // $charge = GoSell\Charges::create(
        //     [
        //       "amount"=> $order->outgoing->total,
        //       "currency"=> "SAR",
        //       "threeDSecure"=> true,
        //       "save_card"=> false,
        //       "description"=> "Test Description",
        //       "statement_descriptor"=> "Sample",
        //       "metadata"=> [
        //         "udf1"=> "test 1",
        //         "udf2"=> "test 2"
        //       ],
        //       "reference"=> [
        //         "transaction"=> "txn_{$order->id}",
        //         "order"=> "order_{$order->id}"
        //       ],
        //       "receipt"=> [
        //         "email"=> false,
        //         "sms"=> true
        //       ],
        //       "customer"=> [
        //         "first_name"=> "test",
        //         "middle_name"=> "test",
        //         "last_name"=> "test",
        //         "email"=> "test@test.com",
        //         "phone"=> [
        //           "country_code"=> "002",
        //           "number"=> "01225209199"
        //         ]
        //       ],
        //       "source"=> [
        //         "id"=> "src_all"
        //       ],
        //     //   "post"=> [
        //     //     "url"=> route('admin.outgoings.response')
        //     //   ],
        //       "redirect"=> [
        //         "url"=> route('admin.outgoings.response')
        //       ]
        //     ]
        // );

        // return redirect($charge->transaction->url); //will give charge response as PHP object
        

        if($payment){
            // send notification to the client
            // send notification to the payer
            // make payment to payer
            $order->update(['status' => 'paid']);
            Alert::toast('<h4>تم ارساله المبلغ بنجاح</h4>','success');
        } else {
            Alert::toast('<h4>حدث خطأ ما , يرجي المحاوله لاحقاً</h4>','error');
        }
        return redirect()->back();

    }


    public function response(Request $request) {
        // GoSell::setPrivateKey("sk_test_DecgsiEPGZFfrNRwYt2hWxvK");
        // $retrieved_charge  = GoSell\Charges::retrieve($request->tap_id);
        // dd($retrieved_charge);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Outgoing  $outgoing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outgoing $outgoing)
    {
        //
    }


    public function ajaxData()
    {
        $outgoings = Outgoing::with('order.userservice.service','order.client','order.user');
        return DataTables::of($outgoings)
        ->addColumn('service', function ($outgoings) {
            return $outgoings->order->userservice->service ? $outgoings->order->userservice->service->title : '------';
        })
        ->addColumn('user', function ($outgoings) {
            return $outgoings->order->user ? $outgoings->order->user->name : '------';
        })
        ->addColumn('client', function ($outgoings) {
            return $outgoings->order->client ? $outgoings->order->client->name : '------';
        })
        ->addColumn('price', function ($outgoings) {
            return $outgoings->order ? $outgoings->order->price : '------';
        })
        ->addColumn('status', function ($outgoings) {
            return $outgoings->order ? $outgoings->order->status : '------';
        })
        ->addColumn('action', function ($outgoings) {
            if($outgoings->order->status == "done"){
                return '<a href="'.route('admin.outgoings.pay',$outgoings->order->id).'" style="float:right"  class="send-money btn btn-xs btn-success"><i class="glyphicon glyphicon-euro"></i> '.__("admin/outgoings.list.send").'</a>';
            }
        })->make(true);
    }
}
