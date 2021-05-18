<table>
    <thead>
        <tr>
            <th>Requested date</th>
            <th>Payer name</th>
            <th>Payment fullname </th>
            <th>Payment bank name</th>
            <th>Payment account name</th>
            <th>Total amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payment_requests as $payment_request)
        <tr>
            <td align="left" valign="top">{{ \Carbon\Carbon::parse($payment_request->created_at)->format("d-m-y H:i") }}</td>
            <td align="left" valign="top">{{ $payment_request->user->name }}</td>
            <td align="left" valign="top">{{ $payment_request->user->bank_account_details->full_name }}</td>
            <td align="left" valign="top">{{ $payment_request->user->bank_account_details->bank_name }}</td>
            <td align="left" valign="top">{{ $payment_request->user->bank_account_details->account_number }}</td>
            <td align="left" valign="top">{{ $payment_request->user->pending_wallet->total_amount }}</td>
        </tr>
        @endforeach
    </tbody>
</table>