@extends('admin.layout.master')

@push('css-files')
<link rel="stylesheet" href="{{ asset('admin-files/css/select2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">@lang("admin/settings.label")</h3>
    </div><!-- /.card-header -->


    @include('admin.layout.components.messages')

    <div class="card-body">
        <form enctype="multipart/form-data" role="form" method="POST" action="{{ route('admin.settings.store') }}">
            <div class="card-body">
              @csrf
          
           <div class="form-group">
              <label for="exampleInputEmail1">@lang("admin/settings.form.site_title")</label>
              <input type="text" name="settings[title]" class="form-control" value="{{old('settings[title]') ? old('settings[title]') : (isset($settings['title']) ? $settings['title'] : '') }}">
          </div>
          
          <div class="form-group">
            <label for="exampleInputEmail1">%@lang("admin/settings.form.site_fees")</label>
            <input type="text" name="settings[percentage]" class="form-control" value="{{old('settings[percentage]') ? old('settings[percentage]') : (isset($settings['percentage']) ? $settings['percentage'] : '') }}">
          </div>




              <div class="form-group">
                <label>@lang("admin/settings.form.site_logo")</label>
                @if(isset($settings['logo']) && $settings['logo']  != "")
                <div class="image_holder">
                  <i class="remove_image fa fa-times-circle"></i>
                  <img src="{{ $settings['logo'] }}" width="100px" height="100px" class="img-rounded" align="center" />
                </div>
                @endif
                <input type="file" name="settings[logo]" class="form-control"  placeholder="@lang("admin/settings.form.site_logo")">
              </div>


              


              <div class="form-group">
                <label for="privacy_policy">@lang("admin/settings.form.privacy_policy")</label>
                <textarea type="text" name="settings[privacy_policy]" class="form-control">{{old('settings[privacy_policy]') ? old('settings[privacy_policy]') : (isset($settings['privacy_policy']) ? $settings['privacy_policy'] : '') }}</textarea>
            </div>

            <div class="form-group">
              <label for="privacy_policy">@lang("admin/settings.form.terms_and_conditions")</label>
              <textarea type="text" name="settings[terms_and_conditions]" class="form-control">{{old('settings[terms_and_conditions]') ? old('settings[terms_and_conditions]') : (isset($settings['terms_and_conditions']) ? $settings['terms_and_conditions'] : '') }}</textarea>
          </div>

          


            </div><!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">@lang("admin/settings.form.save")</button>
            </div>
          </form>

      </div><!-- /.card-body -->
    </div><!-- /.card -->
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