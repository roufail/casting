@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@lang("admin/incomings.list.incomings")</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="incomings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/incomings.list.service")</th>
                    <th>@lang("admin/incomings.list.payer")</th>
                    <th>@lang("admin/incomings.list.client")</th>
                    <th>@lang("admin/incomings.list.price")</th>
                    <th>@lang("admin/incomings.list.status")</th>
                    <th>@lang("admin/incomings.list.received")</th>
                    <th>@lang("admin/incomings.list.delivered")</th>
                    <th>@lang("admin/incomings.list.deliver_date")</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#incomings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.incomings.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'order.userservice.service.title', name: 'order.userservice.service.title'},
                { data: 'order.user.name', name: 'order.user.name'},
                { data: 'order.client.name', name: 'order.client.name' },
                { data: 'order.price', name: 'order.price' },
                { data: 'order.status', name: 'order.status' },
                { data: 'received', name: 'received' },
                { data: 'delivered', name: 'delivered' },
                { data: 'delivered_date', name: 'delivered_date' },
            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#orders-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                    title: `هل تريد حقا حذف هذا الطلب ؟`,
                    text: "هذا الاجراء لايمكن التراجع عنه ",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ['لا', 'نعم']

                })
                .then((willDelete) => {
                    if (willDelete) {
                    form.submit();
                    }
                });
        });
    
    });


</script>
@endsection