<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Wallet;
use App\Models\PaymentRequest;
use Carbon\Carbon;
Use Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentRequestsExport;
class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.wallets.index');
    }

    public function paid_payment_requests()
    {
        $status = "paid";
        return view('admin.wallets.payment_requests',compact('status'));
    }

    public function pending_payment_requests()
    {
        $status = "pending";
        return view('admin.wallets.payment_requests',compact('status'));
    }

    public function payment_requests() {
        $status = "unpaid";
        return view('admin.wallets.payment_requests',compact('status'));
    }




    public function pay(Wallet $wallet) {
        $now = Carbon::now();
        $wallet->update(['status' => 'paid','paid_at' => $now]);
        $wallet->items()->update(['status' => 'paid','paid_at' => $now]);
        Alert::toast('<h4>تم تعديل حاله المحفظه بنجاح</h4>','success');
        return redirect()->back();
    }



    public function get_items(Wallet $wallet) {
        return view('admin.wallets.items',compact('wallet'));
    }

    public function bank_account_details(Request $request) {
        if(!request()->ajax()){
            return abort(404);
        }

        $paymentRequest = PaymentRequest::with('user.bank_account_details')->where('id',$request->id)->first();

        return response()->json($paymentRequest->user->bank_account_details);

    }

    public function payment_request_pay(PaymentRequest $PaymentRequest){
        $wallet = $PaymentRequest->user->pendingWallet;
        $now = Carbon::now();
        $wallet->items()->update(['status' => 'paid','paid_at' => $now]);
        $wallet->update(['status' => 'paid','paid_at' => $now]);
        $PaymentRequest->update(['status' => 'paid','paid_at' => $now]);
        Alert::toast('<h4>تم تعديل حاله المحفظه بنجاح</h4>','success');
        return redirect()->route('admin.wallets.paid_payment_requests');
    }

    public function download_payment_requests(Request $request) {
        $ids = $request->ids;
        $ids = explode(",",$ids);
        if(empty($ids)) return abort(404);
        $payment_requests = PaymentRequest::where('status','unpaid')->whereIn('id',$ids);
        $payment_requests->each(function($payment_request){
            $wallet = $payment_request->user->wallet;
            $wallet->items()->update(['status' => 'pending']);
            $wallet->update(['status' => 'pending']);
        });
        $payment_requests->update(['status' => 'pending']);
        
        $payment_requests_pending = PaymentRequest::with(['user.pendingWallet','user.bank_account_details'])->where('status','pending')->whereIn('id',$ids)->get();
        return Excel::download(new PaymentRequestsExport(json_encode($payment_requests_pending)), 'payment-requests-'.date('d-m-Y').'.xlsx',null, [\Maatwebsite\Excel\Excel::XLSX]);
    }

    public function paymentRequetsAjaxData($status = "unpaid") {

        $paymentRequest = PaymentRequest::query();
        $rel = 'user.wallet';
        switch ($status) {
            case 'pending':
                $rel = 'user.pendingWallet';
                break;
            case 'paid':
                $rel = 'user.paidWallet';
                break;
            default:
            $rel = 'user.wallet';
        }
        $rel_ar = explode('.',$rel);

        $paymentRequest = PaymentRequest::with($rel);
        
        $paymentRequest = $paymentRequest->where("status",$status);
        return Datatables::of($paymentRequest)

        ->addColumn('items', function ($request) {
            return '
            <a  style="float:right" href="'.route('admin.wallets.get_items',$request->request_wallet->id).'" class="btn btn-xs btn-primary"><i class="fa fa-list" aria-hidden="true"></i>            '.__("admin/wallets.list.items").'</a>';
        })

        ->addColumn('action', function ($request) {
            return  '<a  style="float:right" href="'.route('admin.wallets.payment_request_pay',$request->id).'" class="btn btn-xs btn-primary"><i class="fa fa-money" aria-hidden="true"></i> '.__("admin/wallets.request_payments_list.paid").'</a>';
        })        
        ->addColumn('bank_account_details', function ($request) {
            return '<a style="float:right" href="javascript:;" data-id="'.$request->id.'" class="account-details-btn btn btn-xs btn-primary"><i class="fa fa-money" aria-hidden="true"></i> '.__("admin/wallets.request_payments_list.bank_account_details").'</a>';
        })
        ->addColumn('user.wallet.total_amount', function ($request) use($rel_ar) {
            return $request->user->{$rel_ar[1]} ? $request->user->{$rel_ar[1]}->total_amount : 0;
        })
        ->addColumn('checkbox', function ($request) {
            return '<input type="checkbox" class="payment-requests" name="payment_request_ids" value="'.$request->id.'"/>';
        })
        ->rawColumns(['user.wallet.total_amount','items','checkbox','bank_account_details','action'])
        ->make(true);
    }

    // public function pendingPaymentRequetsAjaxData() {
    //     $paymentRequest = PaymentRequest::with('user.wallet')->where("status","pending");
    //     return Datatables::of($paymentRequest)
    //     ->addColumn('action', function ($request) {
    //         return  '<a  style="float:right" href="'.route('admin.wallets.payment_request_pay',$request->id).'" class="btn btn-xs btn-primary"><i class="fa fa-money" aria-hidden="true"></i> '.__("admin/wallets.request_payments_list.paid").'</a>';
    //     })        
    //     ->rawColumns(['action'])
    //     ->make(true);
    // }


    public function itemsAjaxData(Wallet $wallet) {
        $items = $wallet->items->load(['user','client']);
        return Datatables::of($items)
        ->with([
            'total_price'=> $wallet->items ? $wallet->items->sum('service_price') : 0 ,
            'total_fees'=> $wallet->items ? $wallet->items->sum('system_fees') : 0 ,
            'total_amount'=> $wallet->items ? $wallet->items->sum('service_total_amount') : 0 ,
        ])
        ->make(true);
    }
    public function ajaxData()
    {
        $wallets = Wallet::with('user')->where("status","unpaid");
        return Datatables::of($wallets)
        ->addColumn('items', function ($wallet) {
            return '
            <a  style="float:right" href="'.route('admin.wallets.get_items',$wallet->id).'" class="btn btn-xs btn-primary"><i class="fa fa-list" aria-hidden="true"></i>            '.__("admin/wallets.list.items").'</a>';
        })
        ->addColumn('action', function ($wallet) {
            return '
            <a  style="float:right" href="'.route('admin.wallets.pay',$wallet->id).'" class="btn btn-xs btn-primary"><i class="fa fa-money" aria-hidden="true"></i> '.__("admin/wallets.list.pay").'</a>';
        })
        ->rawColumns(['items', 'action'])
        ->make(true);
    }




}
