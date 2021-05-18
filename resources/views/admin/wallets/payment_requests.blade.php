@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">الخدمات</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <table class="table table-bordered" id="payment-requests-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>@lang("admin/wallets.request_payments_list.name")</th>
                    <th>@lang("admin/wallets.request_payments_list.amount")</th>
                    <th>@lang("admin/wallets.request_payments_list.items")</th>
                    @if($status == "unpaid")<th>@lang("admin/wallets.request_payments_list.bank_account_details")</th>@endif
                    @if($status == "paid")<th>@lang("admin/wallets.request_payments_list.paid_at")</th>@endif
                    @if($status == "unpaid")<th><label class="select_all" ><input type="checkbox"/>@lang("admin/wallets.request_payments_list.checkbox")</label></th>@endif
                    @if($status == "pending")<th>@lang("admin/wallets.request_payments_list.paid")</th>@endif
                </tr>
            </thead>
            @if($status == "unpaid")
            <tfoot>
                <tr>
                    <th colspan="6">
                        <a href="javascript:;" class="btn btn-primary text-white btn-download-excel">@lang("admin/wallets.request_payments_list.payment_in_progress")</a>
                    </th>
                </tr>
            </tfoot>
            @endif
        </table>
      </div><!-- /.card-body -->
    </div><!-- /.card -->




<!-- Modal -->
<div class="modal fade" id="account-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('admin\wallets.modal.account_details_for')<span class="account-full-name account-data"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-unstyled">
            <li>@lang('admin\wallets.modal.full_name'): <span class="account-full-name account-data"></span></li>
            <li>@lang('admin\wallets.modal.bank_name'): <span class="account-bank-name account-data"></span></li>
            <li>@lang('admin\wallets.modal.account_number'): <span class="account-account-number account-data"></span></li>
        </ul>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('admin\wallets.modal.close')</button>
        </div>
      </div>
    </div>
  </div>
  

@endsection


@section('extra-js')
<script>
    $(function() {
        $('#payment-requests-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route("admin.wallets.payment_requets_ajax_data",$status) !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'user.name', name: 'user.name', searchable: true},
                { data: 'user.wallet.total_amount', name: 'user.wallet.total_amount'},
                { data: 'items', name: 'items'},
                @if($status == "unpaid"){ data: 'bank_account_details', name: 'bank_account_details'},@endif
                @if($status == "paid"){ data: 'paid_at', name: 'paid_at', searchable: false,sortable:false},@endif
                @if($status == "unpaid"){ data: 'checkbox', name: 'checkbox', searchable: false,sortable:false},@endif
                @if($status == "pending"){ data: 'action', searchable: false,sortable:false }@endif

            ],
            "order": [[ 0, "desc" ]],
            drawCallback:function(data)
            {
                if($('.account-details-btn').length <= 0) {
                    $('.btn-download-excel').remove();
                }

            },



        });

        $('#payment-requests-table').on('click','.account-details-btn',function(e){
            $id = $(this).data('id');
            $('.account-data').text('');
            $.ajax({
                url: '{{ route("admin.wallets.bank_account_details") }}',
                type: 'POST',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : $id
                },
                dataType: 'json',
                success: function( account_data ) {
                    $('#account-details .account-full-name').text(account_data.full_name);
                    $('#account-details .account-bank-name').text(account_data.bank_name);
                    $('#account-details .account-account-number').text(account_data.account_number);
                    $('#account-details').modal('show');

                }
            })
        });

        $('.select_all input[type="checkbox"]').click(function(){
          $('.payment-requests').attr('checked',$(this).is(':checked'));
        })

        $('.btn-download-excel').click(function(){

          const selectedValues = $('input[name="payment_request_ids"]:checked').map(function () { 
            return $(this).val(); 
          })
          .get()
          .join(',');

          if(selectedValues.trim().length <= 0 ){
            swal({
                    title: "@lang('admin/admins.swal.select_title')",
                    text: "@lang('admin/admins.swal.select_body')",
                    icon: "warning",

                });
                return false;
          }



          @if($status == "unpaid")
            window.open('{{ route("admin.wallets.download_payment_requests") }}/?ids='+selectedValues,"_blank");
            window.location = "{{ route('admin.wallets.pending_payment_requests') }}";
          @endif



          });



    
    });


</script>
@endsection

@section('extra-css') 
<style type="text/css">
    .modal-open .modal{
        z-index: 1000000;
        top: 200px;
    }
    .select_all{
      cursor:pointer;
    }
</style>
@endsection