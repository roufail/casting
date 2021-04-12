@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">الخدمات</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="outgoings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/outgoings.list.service")</th>
                    <th>@lang("admin/outgoings.list.payer")</th>
                    <th>@lang("admin/outgoings.list.client")</th>
                    <th>@lang("admin/outgoings.list.price")</th>
                    <th>@lang("admin/outgoings.list.fees")</th>
                    <th>@lang("admin/outgoings.list.total")</th>
                    <th>@lang("admin/outgoings.list.status")</th>
                    <th>@lang("admin/outgoings.list.edit")</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#outgoings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.outgoings.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'service', name: 'service', searchable: true},
                { data: 'user', name: 'user', searchable: true},
                { data: 'client', name: 'client', searchable: true },
                { data: 'price', name: 'price' },
                { data: 'fees', name: 'fees' },
                { data: 'total', name: 'total' },
                { data: 'status', name: 'status' },
                { data: 'action', searchable: false,sortable:false },

            ],
            "order": [[ 0, "desc" ]]

        });

    
    });


</script>
@endsection