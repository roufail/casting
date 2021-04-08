@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    Echo.private('chat-channel.1')
        .listen(('.message') => {
            console.log(message);
    });



    Echo.private('chat-channel.payer.362')
        .listen(('.message') => {
            console.log(message);
    });
</script>


@endsection
