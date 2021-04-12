@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@if($category->id) @lang('admin/categories.form.edit_user') {{$category->name}}@else @lang('admin/categories.form.new_user') @endif</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $category->id ? route('admin.categories.update',$category->id) : route('admin.categories.store') }}">
            <div class="card-body">
              @csrf
              @if ($category->id)
                @method('put')  
              @endif
              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/categories.form.title')</label>
                <input type="text" name="title" class="form-control" value="{{old_value('title',$category)}}">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/categories.form.description')</label>
                <textarea type="text" name="description" class="form-control">{{old_value('description',$category)}}</textarea>  
            </div>





              <div class="form-group">
                <label>@lang('admin/categories.form.image')</label>
                @if($category->image != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ \Storage::disk("categories")->url($category->image)}}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="image" class="form-control"  placeholder="@lang('admin/categories.form.image')">
              </div>



              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($category->active || old('active')) checked @endif> @lang('admin/categories.form.active')
                </label>
              </div>
            </div><!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang('admin/categories.form.save')</button>
            </div>
          </form>
      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2();
    @if($category->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.categories.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $category->id}}
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