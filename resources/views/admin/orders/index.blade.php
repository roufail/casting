@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">
            @lang('admin/orders.list.orders')
      </h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
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
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
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
                { data: 'chat', name: 'chat'}

            ],
            "order": [[ 0, "desc" ]]

        });
    
     
    
    });


</script>
@endsection