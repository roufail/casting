@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">الخدمات</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <table class="table table-bordered" id="outgoings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الخدمه</th>
                    <th>البائع</th>
                    <th>العميل</th>
                    <th>السعر</th>
                    <th>الرسوم</th>
                    <th>الاجمالي</th>
                    <th>الحاله</th>
                    <th>تعديل</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
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