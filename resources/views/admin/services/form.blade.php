@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@if($service->id) @lang("admin/services.form.edit_service") {{$service->name}}@else @lang("admin/services.form.new_service") @endif</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $service->id ? route('admin.services.update',$service->id) : route('admin.services.store') }}">
            <div class="card-body">
              @csrf
              @if ($service->id)
                @method('put')  
              @endif
              <div class="form-group">
                <label for="exampleInputEmail1">@lang("admin/services.form.title")</label>
                <input type="text" name="title" class="form-control" value="{{old_value('title',$service)}}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">@lang("admin/services.form.description")</label>
                <textarea type="text" name="description" class="form-control">{{old_value('description',$service)}}</textarea>  
            </div>



            <div class="form-group">
              <label>التصنيف</label>
              <select dir="rtl" name="category_id" class="form-control select2">
                @foreach ($categories as $key => $item)
                   <option value="{{  $key }}" @if($key == $service->category_id) selected @endif>{{ $item }}</option>
                @endforeach
              </select>
            </div>




              <div class="form-group">
                <label>@lang("admin/services.form.image")</label>
                @if($service->image != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ \Storage::disk("services")->url($service->image)}}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="image" class="form-control"  placeholder="@lang("admin/services.form.image")">
              </div>



              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($service->active || old('active')) checked @endif> @lang("admin/services.form.active")
                </label>
              </div>
            </div><!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang("admin/services.form.save")</button>
            </div>
          </form>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2();
    @if($service->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.services.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $service->id}}
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