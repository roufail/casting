@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">@if($user->id) @lang('admin/users.form.edit_user') {{$user->name}}@else @lang('admin/users.form.edit_user') @endif</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $user->id ? route('admin.users.update',$user->id) : route('admin.users.store') }}">
            <div class="box-body">
              @csrf
              @if ($user->id)
                @method('put')  
              @endif
            <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.name')</label>
                <input type="text" name="name" class="form-control" value="{{old_value('name',$user)}}">
            </div>

              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.email')</label>
                <input type="email" name="email" class="form-control"  value="{{old_value('email',$user)}}" placeholder="@lang('admin/users.form.email')">
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.birthday')</label>
                <input dir="ltr" type="date" name="dob" class="form-control"  value="{{old_value('dob',$user)}}" placeholder="@lang('admin/users.form.birthday')">
              </div>



              <div class="form-group">
                <label for="exampleInputPassword1">@lang('admin/users.form.password')</label>
                <input type="password" name="password" class="form-control"  placeholder="@lang('admin/users.form.password')">
              </div>

              <div class="form-group">
                <label for="exampleInputPassword1">@lang('admin/users.form.re_password')</label>
                <input type="password" name="password_confirmation" class="form-control"  placeholder="@lang('admin/users.form.re_password')">
              </div>

              <div class="form-group">
                <label>@lang('admin/users.form.country')</label>
                <select dir="rtl" name="country" class="form-control select2">
                  @foreach (arabic_country_array() as $key => $item)
                     <option value="{{  $item }}" @if($item == $user->country) selected @endif>{{ $item }}</option>
                  @endforeach
                </select>
              </div>



              <div class="form-group">
                <label>@lang('admin/users.form.image')</label>
                @if($user->image != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ \Storage::disk("users")->url($user->image)}}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="image" class="form-control"  placeholder="@lang('admin/users.form.image')">
              </div>


              {{-- <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.bio')</label>
                <textarea type="text" name="bio" class="form-control">{{old_value('bio',$user)}}</textarea>  
              </div> --}}

              @if($services->count() > 0)
              <div class="form-group">
                <label>@lang('admin/users.form.services')</label>
                  <ul class="row services-ul list-unstyled">
                        
                    @if ($user->services->count() > 0)
                        @foreach ($user->services as $key => $userService)
                        <li class="col-md-12">
                          <label class="col-md-3">
                            @lang('admin/users.services.name')
                            <select name="services[{{$key}}][service_id]"  class="form-control select2">
                              @foreach ($services as  $service)
                                <option value="{{ $service->id }}" @if($userService->service_id == $service->id) selected @endif>{{ $service->title }}</option>
                              @endforeach
    
                            </select>
                          </label>
    
                          <label class="col-md-3">
                            @lang('admin/users.services.price')
                            <input value="{{ $userService->price }}" name="services[{{$key}}][price]" type="text" class="form-control"/>
                          </label>
    
                          <label class="col-md-3">
                            @lang('admin/users.services.period')
                            <input value="{{ $userService->work_type }}"  name="services[{{$key}}][work_type]" type="text" class="form-control"/>
                          </label>
                          <div class="col-md-3"><a class="delete_service" href="javascript:;"><i class="fa fa-minus"></i>@lang('admin/users.services.delete')</a></div>

                        </li> 
                        @endforeach
                    @elseif(old('services'))

                    @foreach (old('services') as $serviceKey => $userService)
                    <li class="col-md-12">
                      <label class="col-md-3">
                        @lang('admin/users.services.name')
                        <select name="services[{{$serviceKey}}][service_id]"  class="form-control select2">
                          @foreach ($services as  $key => $service)
                            <option value="{{ $service->id }}" @if($userService['service_id'] == $service->id) selected @endif>{{ $service->title }}</option>
                          @endforeach

                        </select>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.price')
                        <input value="{{ $userService['price'] }}" name="services[{{$serviceKey}}][price]" type="text" class="form-control"/>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.period')
                        <input value="{{ $userService['work_type'] }}"  name="services[{{$serviceKey}}][work_type]" type="text" class="form-control"/>
                      </label>
                      <div class="col-md-3"><a class="delete_service" href="javascript:;"><i class="fa fa-minus"></i>@lang('admin/users.services.delete')</a></div>
                    </li> 
                    @endforeach


                    @else
                    <li class="col-md-12">
                      <label class="col-md-3">
                        @lang('admin/users.services.name')
                        <select name="services[0][service_id]"  class="form-control select2">
                          @foreach ($services as  $service)
                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                          @endforeach

                        </select>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.price')
                        <input name="services[0][price]" type="text" class="form-control"/>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.period')
                        <input name="services[0][work_type]" type="text" class="form-control"/>
                      </label>
                      <div class="col-md-3"><a class="delete_service" href="javascript:;"><i class="fa fa-minus"></i>@lang('admin/users.services.delete')</a></div>
                    </li>  
                    @endif





                

                  </ul>
                  
                  <a href="javascript:;" class="add_services_handler">
                    <i class="fa fa-plus"></i>                            
                    @lang('admin/users.services.add_new_service')

                  </a>

              </div>
              @endif




              <div class="checkbox">
                <label>
                  <input name="active" type="checkbox" @if($user->active || old('active')) checked @endif>
                  @lang('admin/users.services.active')
                </label>
              </div>


              



            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">@lang('admin/users.form.submit')</button>
            </div>
          </form>
          <form method="post" action="{{route('admin.users.upload_images')}}" enctype="multipart/form-data" 
          class="dropzone" id="dropzone">
            @csrf
          </form>   


      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2()
    @if($user->id)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.users.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $user->id}}
                },
                dataType: 'json',
                success: function( data ) {
                  $('.image_holder').remove();
                }
            })
    });
    @endif

    $(".add_services_handler").click(function(){
      const $length = $('.services-ul li').length;
      $('.services-ul').append(`
      <li class="col-md-12">
                      <label class="col-md-3">
                        @lang('admin/users.services.name')
                        <select  name="services[${$length}][service_id]" class="form-control select2">
                          @foreach ($services as  $service)
                            <option value="{{ $service->id }}">{{ $service->title }}</option>
                          @endforeach
                      </select>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.price')
                        <input name="services[${$length}][price]" type="text" class="form-control"/>
                      </label>

                      <label class="col-md-3">
                        @lang('admin/users.services.period')
                        <input name="services[${$length}][work_type]" type="text" class="form-control"/>
                      </label>
                      <div class="col-md-3"><a class="delete_service" href="javascript:;"><i class="fa fa-minus"></i>حذف</a></div>
                    </li>
      `);
    });

    $('.services-ul').on("click",".delete_service",function(){

      swal({
        title: "@lang('admin/users.service_swal.delete_title')",
                    text: "@lang('admin/users.service_swal.delete_body')",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          buttons: ["@lang('admin/users.service_swal.no')","@lang('admin/users.service_swal.yes')"]
          })
          .then((willDelete) => {
              if (willDelete) {
                $(this).closest("li").remove();
              }
          });
      })
    

    Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(name) {
               return name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file, serverFileName) 
            {
                var name    = file.upload.filename;
                $servername = file.previewElement.querySelector("img").src;
                $.ajax({
                    headers: {
                      'X-CSRF-TOKEN': '{{ csrf_token()}}'
                            },
                    type: 'POST',
                    url: '{{ route("admin.users.remove_dropzone_image") }}',
                    data: {image: $servername},
                    success: function (data){
                        
                        console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
              console.log(response);
              file.previewElement.querySelector("img").src = response.name;
            },
            error: function(file, response)
            {
               return false;
            }
          };

  })
</script>
@endsection

@push('js-files')
   <script src="{{ asset('admin-files/js/select2.min.js') }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
@endpush