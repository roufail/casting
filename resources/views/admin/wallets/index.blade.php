@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">المحافظ</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="wallets-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/wallets.list.name")</th>
                    <th>@lang("admin/wallets.list.amount")</th>
                    <th>@lang("admin/wallets.list.items")</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#wallets-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.wallets.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.name', name: 'user.name', searchable: true},
                { data: 'total_amount', name: 'total_amount', searchable: true},
                { data: 'items', name: 'items'},
            ],
            "order": [[ 0, "desc" ]]

        });

    
    });


</script>
@endsection