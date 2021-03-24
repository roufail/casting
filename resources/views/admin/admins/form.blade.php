@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">@if($admin->id) @lang('admin/admins.form.edit_user') {{$admin->name}}@else @lang('admin/admins.form.new_user') @endif</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $admin->id ? route('admin.admins.update',$admin->id) : route('admin.admins.store') }}">
            <div class="box-body">
              @csrf
              @if ($admin->id)
                @method('put')  
              @endif
            <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/admins.form.name')</label>
                <input type="text" name="name" class="form-control" value="{{old_value('name',$admin)}}">
            </div>

              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/admins.form.email')</label>
                <input type="email" name="email" class="form-control"  value="{{old_value('email',$admin)}}" placeholder="@lang('admin/admins.form.email')">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">@lang('admin/admins.form.password')</label>
                <input type="password" name="password" class="form-control"  placeholder="@lang('admin/admins.form.password')">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">@lang('admin/admins.form.re_password')</label>
                <input type="password" name="password_confirmation" class="form-control"  placeholder="@lang('admin/admins.form.re_password')">
              </div>


            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">@lang('admin/admins.form.submit')</button>
            </div>
          </form>

      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2()
    @if($admin->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.clients.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $admin->id}}
                },
                dataType: 'json',
                success: function( data ) {
                  $('.image_holder').remove();
                }
            })
    });
    @endif

  
  })
</script>
@endsection

@push('js-files')
   <script src="{{ asset('admin-files/js/select2.min.js') }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
@endpush