@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
        <a href="{{ route("admin.categories.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="box-title">الخدمات</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <table class="table table-bordered" id="categories-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/categories.list.image')</th>
                    <th>@lang('admin/categories.list.title')</th>
                    <th>@lang('admin/categories.list.edit')</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#categories-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.categories.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image' },
                { data: 'title', name: 'title' },
                { data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#categories-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                title: "@lang('admin/categories.swal.delete_title')",
                    text: "@lang('admin/categories.swal.delete_body')",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["@lang('admin/categories.swal.no')", "@lang('admin/categories.swal.yes')"]


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