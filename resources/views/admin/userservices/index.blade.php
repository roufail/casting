@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route("admin.userservices.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="card-title">الخدمات</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="userservices-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/userservice.list.service')</th>
                    <th>@lang('admin/userservice.list.price')</th>
                    <th>@lang('admin/userservice.list.work_type')</th>
                    <th>@lang('admin/userservice.list.edit')</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#userservices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.userservices.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'service.title', name: 'service.title' },
                { data: 'price', name: 'price' },
                { data: 'work_type', name: 'work_type' },
                { data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#userservices-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                title: "@lang('admin/userservice.swal.delete_title')",
                    text: "@lang('admin/userservice.swal.delete_body')",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["@lang('admin/userservice.swal.no')", "@lang('admin/userservice.swal.yes')"]
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