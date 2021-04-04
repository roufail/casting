@extends('admin.layout.master')

@section('content')



<div class="card direct-chat direct-chat-primary">
    <div class="card-header">
      <h3 class="card-title">{{  $order->userservice->service->title }}</h3>

    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <!-- Conversations are loaded here -->
      <div>

        @foreach ($order->chat->messages as $message)
        <!-- Message. Default to the left -->
        @php
          $user_type = $message->user_type;
          $disk      = $user_type == "payer" ? "users" : "clients";
        @endphp
        <div class="direct-chat-msg @if($user_type == "payer") right @endif">
          <div class="direct-chat-info clearfix">
            <span class="direct-chat-name float-left">{{$message->$user_type->name}}</span>
            <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
          </div>
          <!-- /.direct-chat-info -->
          <img class="direct-chat-img" src="{{ \Storage::disk($disk)->url($message->$user_type->image) }}" alt="message user image">
          <!-- /.direct-chat-img -->
          <div class="direct-chat-text">
            @if ($message->message_type == "image")
                <img class="direct-chat-img" src="{{$message->message}}" />
              @else
              {{$message->message}}
            @endif
          </div>
          <!-- /.direct-chat-text -->
        </div>
        <!-- /.direct-chat-msg -->
        @endforeach




        

      </div>
      <!--/.direct-chat-messages-->
    
      <!-- /.direct-chat-pane -->
    </div>
    <!-- /.card-body -->
  </div>
@endsection
