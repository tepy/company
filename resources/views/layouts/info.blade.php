@if($errors->any())
    <div class="alert alert-primary" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success">
        <strong>{{ \Illuminate\Support\Facades\Session::get('success') }}</strong>
    </div>
@endif