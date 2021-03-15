@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endpush

@section('content')
<div class="box">
    <div class="box-header">
      <h3 class="box-title">اعدادات الموقع</h3>
    </div><!-- /.box-header -->


    @include('admin.layout.components.messages')

    <div class="box-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ route('admin.settings.store') }}">
            <div class="box-body">
              @csrf
          
           <div class="form-group">
              <label for="exampleInputEmail1">عنوان الموقع</label>
              <input type="text" name="settings[title]" class="form-control" value="{{old('settings[title]') ? old('settings[title]') : (isset($settings['title']) ? $settings['title'] : '') }}">
          </div>
          
          <div class="form-group">
            <label for="exampleInputEmail1">نسبه الموقع</label>
            <input type="text" name="settings[percentage]" class="form-control" value="{{old('settings[percentage]') ? old('settings[percentage]') : (isset($settings['percentage']) ? $settings['percentage'] : '') }}">
          </div>




              <div class="form-group">
                <label>الشعار</label>
                @if(isset($settings['logo']) && $settings['logo']  != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ $settings['logo'] }}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="settings[logo]" class="form-control"  placeholder="صوره">
              </div>


              



            </div><!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>

      </div><!-- /.box-body -->
    </div><!-- /.box -->
@endsection


@section('extra-js')
<script>
  $(function($){
    $(".select2").select2()
    @if($settings)
    $(".remove_image").click(function(e){
      $.ajax({
                url: '{{ route("admin.settings.delete_image") }}',
                type: 'GET',
                data: { 
                  '_token': '{{ csrf_token() }}',
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