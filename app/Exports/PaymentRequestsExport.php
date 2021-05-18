<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentRequestsExport implements FromView,ShouldAutoSize
{
    private $payment_requests;

    public function __construct($payment_requests){
        $this->payment_requests = $payment_requests;
    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        return view('admin.wallets.payment_requests_exports', [
            'payment_requests' => json_decode($this->payment_requests)
        ]);
    }
}
