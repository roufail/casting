@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">@if($service->id) تعديل {{$service->name}}@else مستخدم جديد @endif</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $service->id ? route('admin.services.update',$service->id) : route('admin.services.store') }}">
            <div class="box-body">
              @csrf
              @if ($service->id)
                @method('put')  
              @endif
              <div class="form-group">
                <label for="exampleInputEmail1">العنوان</label>
                <input type="text" name="title" class="form-control" value="{{old_value('title',$service)}}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">الوصف</label>
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
                <label>الصوره</label>
                @if($service->image != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ \Storage::disk("services")->url($service->image)}}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="image" class="form-control"  placeholder="صوره">
              </div>



              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($service->active || old('active')) checked @endif> مفعل
                </label>
              </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
          </form>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
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