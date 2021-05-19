@extends('admin.layout.master')

@section('content')
<div class="card">
    <div class="card-header">
      <h3 class="card-title">
            @lang('admin/notifications.list.notifications')
      </h3>
    </div><!-- /.card-header -->



    <div class="card-body">
        <table class="table table-bordered" id="notifications-table">
            <thead>
                <tr>
                    <th>@lang('admin/notifications.list.notifications')</th>
                    <th>@lang('admin/notifications.list.date')</th>
                </tr>
            </thead>

            @foreach ($notifications as $notification)
            @php $data = json_decode($notification)->data;@endphp
            <tr>
                <th>{{ $data->notification }}</th>
                <th>{{ Carbon\Carbon::parse($notification->created_at)->diffForHumans()}}</th>
            </tr>
            @endforeach


        </table>


      </div><!-- /.card-body -->

        {{ $notifications->render("pagination::bootstrap-4") }}

    </div><!-- /.card -->
@endsection