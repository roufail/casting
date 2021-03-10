@if (Session::has('success'))
    <div class="alert alert-success alert-dismissable">
        <h4>{{ Session::get('success') }}</h4>
    </div>  
@endif




@if ($errors->any())
    <div class="alert alert-danger alert-dismissable">
        <ul class='list-unstyled'>
            @foreach ($errors->all() as $error)
                <li><h4>{{ $error }}</h4></li>
            @endforeach
        </ul>
    </div>  
@endif
