@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">الخدمات</h3>
        <p class="card-tools"><a href="{{ route('admin.wallets.index') }}">رجوع</a></p>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')
    <div class="card-body">
        <table class="table table-bordered" id="wallet-items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/wallets.items_list.payer")</th>
                    <th>@lang("admin/wallets.items_list.client")</th>
                    <th>@lang("admin/wallets.items_list.service")</th>
                    <th>@lang("admin/wallets.items_list.price")</th>
                    <th>@lang("admin/wallets.items_list.fees")</th>
                    <th>@lang("admin/wallets.items_list.total")</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                <th colspan="4"></th>
                <th id="total_price"></th>
                <th id="total_fees"></th>
                <th id="total_amount"></th>
                </tr>
               </tfoot>

               
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#wallet-items-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.wallets.items_ajax_data",$wallet->id) !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.name', name: 'user.name', searchable: true},
                { data: 'client.name', name: 'client.name', searchable: true},
                { data: 'service_title', name: 'service_title'},
                { data: 'service_price', name: 'service_price'},
                { data: 'system_fees', name: 'system_fees'},
                { data: 'service_total_amount', name: 'service_total_amount'},
            ],
            "order": [[ 0, "desc" ]],
            drawCallback:function(data)
            {
                $('#total_price').html(data.json.total_price);
                $('#total_fees').html(data.json.total_fees);
                $('#total_amount').html(data.json.total_amount);
            },



        });

    
    });


</script>
@endsection