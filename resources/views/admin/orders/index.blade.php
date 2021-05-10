@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">
            @lang('admin/orders.list.orders')
      </h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="orders-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/orders.list.service')</th>
                    <th>@lang('admin/orders.list.payer')</th>
                    <th>@lang('admin/orders.list.client')</th>
                    <th>@lang('admin/orders.list.price')</th>
                    <th>@lang('admin/orders.list.status')</th>
                    <th>@lang('admin/orders.list.chat')</th>
                    <th>@lang('admin/orders.list.charge_id')</th>
                    <th>@lang('admin/orders.list.source_id')</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.orders.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'service', name: 'service', searchable: true},
                { data: 'user', name: 'user', searchable: true},
                { data: 'client', name: 'client', searchable: true },
                { data: 'price', name: 'price' },
                { data: 'status', name: 'status' },
                { data: 'chat', name: 'chat'},
                { data: 'charge_id', name: 'charge_id'},
                { data: 'source_id', name: 'source_id'}
            ],
            "order": [[ 0, "desc" ]]

        });
    
     
    
    });


</script>
@endsection