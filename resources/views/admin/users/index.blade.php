@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route("admin.users.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="card-title">المستخدمين</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/users.list.image')</th>
                    <th>@lang('admin/users.list.name')</th>
                    <th>@lang('admin/users.list.email')</th>
                    <th>@lang('admin/users.list.country')</th>
                    <th>@lang('admin/users.list.edit')</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.users.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'image', name: 'image' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'country', name: 'country' },
                { data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#users-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                    title: "@lang('admin/admins.swal.delete_title')",
                    text: "@lang('admin/admins.swal.delete_body')",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["@lang('admin/admins.swal.no')", "@lang('admin/admins.swal.yes')"]

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