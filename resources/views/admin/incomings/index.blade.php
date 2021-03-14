@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">الخدمات</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <table class="table table-bordered" id="incomings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الخدمه</th>
                    <th>البائع</th>
                    <th>العميل</th>
                    <th>السعر</th>
                    <th>الحاله</th>
                    <th>تم الاستلام</th>
                    <th>تم التسليم</th>
                    <th>تاريخ التسليم</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
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