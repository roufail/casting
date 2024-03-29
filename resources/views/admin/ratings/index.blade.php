@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">التقييمات</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="ratings-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/ratings.list.service")</th>
                    <th>@lang("admin/ratings.list.payer")</th>
                    <th>@lang("admin/ratings.list.client")</th>
                    <th>@lang("admin/ratings.list.rate")</th>
                    <th>@lang("admin/ratings.list.feedback")</th>
                    <th>@lang("admin/ratings.list.edit")</th>
                </tr>
            </thead>
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
    $(function() {
        $('#ratings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.ratings.ajax_data") !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'service.title', name: 'service.title'},
                { data: 'userservice.user.name', name: 'userservice.user.name'},
                { data: 'client.name', name: 'client.name' },
                { data: 'rate', name: 'rate' },
                { data: 'feedback', name: 'feedback' },
                { data: 'action', name: 'action',sortable:false,searchable:false },

            ],
            "order": [[ 0, "desc" ]]

        });
    
        $('#ratings-table').on("click",".delete-record",function(e){
            e.preventDefault();
            var form =  $(this).closest("form");

            swal({
                    title: `هل تريد حقا حذف هذا التقييم ؟`,
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