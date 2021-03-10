@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
        <a href="{{ route("admin.services.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="box-title">الخدمات</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <table class="table table-bordered" id="services-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الصوره</th>
                    <th>العنوان</th>
                    <th>التصنيف</th>
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
        $('#services-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.services.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image' },
                { data: 'title', name: 'title' },
                { data: 'category', name: 'category' },
                { data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#services-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                    title: `هل تريد حقا حذف هذه الخدمه ؟`,
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