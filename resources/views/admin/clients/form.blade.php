@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">@if($client->id) @lang("admin/clients.form.edit_client") {{$client->name}}@else @lang("admin/clients.form.new_client") @endif</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $client->id ? route('admin.clients.update',$client->id) : route('admin.clients.store') }}">
            <div class="box-body">
              @csrf
              @if ($client->id)
                @method('put')  
              @endif
            <div class="form-group">
                <label for="exampleInputEmail1">@lang("admin/clients.form.name")</label>
                <input type="text" name="name" class="form-control" value="{{old_value('name',$client)}}">
            </div>

              <div class="form-group">
                <label for="exampleInputEmail1">@lang("admin/clients.form.email")</label>
                <input type="email" name="email" class="form-control"  value="{{old_value('email',$client)}}" placeholder="Enter email">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">@lang("admin/clients.form.password")</label>
                <input type="password" name="password" class="form-control"  placeholder="Password">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">@lang("admin/clients.form.re_password")</label>
                <input type="password" name="password_confirmation" class="form-control"  placeholder="Password Conformation">
              </div>

              <div class="form-group">
                <label>@lang("admin/clients.form.country")</label>
                <select dir="rtl" name="country" class="form-control select2">
                  @foreach (arabic_country_array() as $key => $item)
                     <option value="{{  $item }}" @if($item == $client->country) selected @endif>{{ $item }}</option>
                  @endforeach
                </select>
              </div>



              <div class="form-group">
                <label>@lang("admin/clients.form.image")</label>
                @if($client->image != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ \Storage::disk("clients")->url($client->image)}}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="image" class="form-control"  placeholder="@lang("admin/clients.form.image")">
              </div>

              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($client->active || old('active')) checked @endif> @lang("admin/clients.form.active")
                </label>
              </div>


              



            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">@lang('admin/clients.form.submit')</button>
            </div>
          </form>

      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2()
    @if($client->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.clients.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $client->id}}
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