@extends('admin.layout.master')

@section('content')
<div class="box">
    <div class="box-header">
        <a href="{{ route("admin.admins.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="box-title">العملاء</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <table class="table table-bordered" id="admins-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('admin/admins.list.name')</th>
                    <th>@lang('admin/admins.list.email')</th>
                    <th>@lang('admin/admins.list.edit')</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#admins-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.admins.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'action', name: 'action', orderable: false, searchable: false}

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#admins-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                    title: `@lang('admin/admins.swal.delete_title')`,
                    text: "@lang('admin/admins.swal.delete_body')",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: [@lang("admin/admins.swal.yes"), @lang("admin/admins.swal.no")]

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