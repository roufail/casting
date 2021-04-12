@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route("admin.clients.create") }} "><i class="fa fa-user-plus pull-left"></i></a>

      <h3 class="card-title">العملاء</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="clients-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/clients.list.image")</th>
                    <th>@lang("admin/clients.list.name")</th>
                    <th>@lang("admin/clients.list.email")</th>
                    <th>@lang("admin/clients.list.country")</th>
                    <th>@lang("admin/clients.list.edit")</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#clients-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.clients.ajax_data") !!}',
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
    
        $('#clients-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                title: "@lang('admin/clients.swal.delete_title')",
                    text: "@lang('admin/clients.swal.delete_body')",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["@lang('admin/clients.swal.no')", "@lang('admin/clients.swal.yes')"]

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