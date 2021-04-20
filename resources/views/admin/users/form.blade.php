@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
@endpush
@section("extra-css")
  <style>
  .dropzone .dz-preview .dz-image img {
      width: 100% !important;
      height: 100% !important;
  }
  </style>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@if($user->id) @lang('admin/users.form.edit_user') {{$user->name}}@else @lang('admin/users.form.edit_user') @endif</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ $user->id ? route('admin.users.update',$user->id) : route('admin.users.store') }}">
            <div class="card-body">
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
                <label for="exampleInputEmail1">@lang('admin/users.form.job_title')</label>
                <input  type="text" name="job_title" class="form-control"  value="{{old('job_title') ? old('job_title') : ( $user->payer_data ? $user->payer_data->job_title : "")}}" placeholder="@lang('admin/users.form.job_title')">
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.prev_work')</label>
                <input  type="text" name="prev_work" class="form-control" placeholder="@lang('admin/users.form.prev_work')" value="{{old('prev_work') ? old('prev_work') : ( $user->payer_data ? $user->payer_data->prev_work : "")}}">
                <small class="text-muted">@lang('admin/users.form.prev_work_help')</small>
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">@lang('admin/users.form.bio')</label>
                <textarea  name="bio" class="form-control" placeholder="@lang('admin/users.form.bio')">{{old('bio') ? old('bio') : ( $user->payer_data ? $user->payer_data->bio : "")}}</textarea>
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


              <div class="payer-images">
                @foreach ($user->work_images as $image)
                  <input type="hidden" name="work_images[]" value="{{ $image->image_url }}" /> 
                @endforeach
              </div>

              <div class="payer-video">
                @if ($user->work_video)
                  <input type="hidden" name="work_video" value="{{ $user->work_video->video_url }}" /> 
                @endif
              </div>



            </div><!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang('admin/users.form.submit')</button>
            </div>
          </form>
          <form method="post" action="{{route('admin.users.upload_images')}}" enctype="multipart/form-data" 
           class="dropzone" id="dropzone">
            @csrf
          </form>  
          
          

          @if ($user->work_video)
            <div class="video_holder">
              <i class="remove_video fa fa-times-circle"></i>
              <video width="300px" height="200px" autoplay  controls="true" src="{{ \Storage::disk("work_videos")->url($user->work_video->video_url) }}"> </video>
            </div>
          @endif


          <form id="video_form" method="POST" action="{{ route('admin.users.video.upload') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="video">@lang('admin/users.form.video')</label>    
                <input accept=".mp4" name="video" id="video" type="file" class="form-control"><br/>
                <div class="progress">
                    <div class="bar"></div >
                    <div class="percent">0%</div >
                </div>
                <input type="submit"  value="@lang('admin/users.form.submit')" class="btn btn-success">
            </div>
        </form>    



      </div><!-- /.card-body -->
    </div><!-- /.card -->
@endsection


@section('extra-js')
<script>
  Dropzone.autoDiscover = false;

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
                  $('.payer-video input').remove();
                }
            })
    });

    $(".remove_video").click(function(e){
      $.ajax({
                url: '{{ route("admin.users.delete_video") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
                  'id'    : {{ $user->id}}
                },
                dataType: 'json',
                success: function( data ) {
                  $('.payer-video').remove();
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
      $(".select2").select2();
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


      var dropzoneOptions = {
           init:function(){
              thisDropzone = this;
              @foreach ($user->work_images as $image)              
              var mockFile = {  name: "{{ $image->image_url }}" , upload:{}};  
                  mockFile.upload.filename =    "{{ $image->image_url }}";  
                  thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                  thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "{{ Storage::disk('work_images')->url($image->image_url) }}");
                  mockFile.previewElement.classList.add('dz-success');
                  mockFile.previewElement.classList.add('dz-complete');
              @endforeach
           },
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
                      $(`.payer-images input[value='${data.name}']`).remove();
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
              $('.payer-images').append(`
                  <input type="hidden" name="work_images[]" value="${response.name}" /> 
              `);
              file.previewElement.querySelector("img").src = response.url;
            },
            error: function(file, response)
            {
               return false;
            }
          };
            var uploader = document.querySelector('#dropzone');
            var newDropzone = new Dropzone(uploader, dropzoneOptions);
        
  })
</script>

<script type="text/javascript">
 
  function validate(formData, jqForm, options) {
      var form = jqForm[0];
      if (!form.video.value) {
          alert('File not found');
          return false;
      }
  }

  (function() {

  var bar = $('.bar');
  var percent = $('.percent');
  var status = $('#status');

  $('#video_form').ajaxForm({
      beforeSubmit: validate,
      beforeSend: function() {
          status.empty();
          var percentVal = '0%';
          var posterValue = $('input[name=video]').fieldValue();
          bar.width(percentVal)
          percent.html(percentVal);
      },
      uploadProgress: function(event, position, total, percentComplete) {
          var percentVal = percentComplete + '%';
          bar.width(percentVal)
          percent.html(percentVal);
      },
      success: function() {
          var percentVal = 'Wait, Saving';
          bar.width(percentVal)
          percent.html(percentVal);
      },
      complete: function(xhr) {
          status.html(xhr.responseText);
          let response = JSON.parse(xhr.responseText);
          $('.payer-video input').remove();
          $('.payer-video').append(`<input type="hidden" name="work_video" value="${response.name}" />`);

          // window.location.href = "/file-upload";
      }
  });
  })();
</script>

@endsection

@push('js-files')
   <script src="{{ asset('admin-files/js/select2.min.js') }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
@endpush