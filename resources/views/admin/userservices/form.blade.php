@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">@if($userservice->id) @lang("admin/userservice.form.edit_service") {{$userservice->name}}@else @lang("admin/userservice.form.new_service") @endif</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $userservice->id ? route('admin.userservices.update',$userservice->id) : route('admin.userservices.store') }}">
            <div class="box-body">
              @csrf
              @if ($userservice->id)
                @method('put')  
              @endif


              <div class="form-group">
                <label>@lang("admin/userservice.form.category")</label>
                <select dir="rtl" name="user_id" class="form-control select2">
                  @foreach ($users as $key => $user)
                     <option value="{{  $key }}" @if($key == $userservice->user_id) selected @endif>{{ $user }}</option>
                  @endforeach
                </select>
              </div>
  
  
  
              <div class="form-group">
                <label for="exampleInputEmail1">@lang("admin/userservice.form.price")</label>
                <input type="text" name="price" class="form-control" value="{{old_value('price',$userservice)}}">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">@lang("admin/userservice.form.work_type")</label>
              <input type="text" name="work_type" class="form-control" value="{{old_value('work_type',$userservice)}}">
          </div>



            <div class="form-group">
              <label>@lang("admin/userservice.form.service")</label>
              <select dir="rtl" name="service_id" class="form-control select2">
                @foreach ($services as $key => $item)
                   <option value="{{  $key }}" @if($key == $userservice->service_id) selected @endif>{{ $item }}</option>
                @endforeach
              </select>
            </div>



              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($userservice->active || old('active')) checked @endif> @lang("admin/userservice.form.service")
                </label>
              </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">@lang("admin/userservice.form.save")</button>
            </div>
          </form>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2();
    @if($userservice->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.userservices.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $userservice->id}}
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
@endpush