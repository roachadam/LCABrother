
<div class='notifications top-right'>
    {{-- {{dd(Session()->all())}} --}}
    {{-- {{Session::forget('success')}} --}}
    @if(Session::has('success'))
        {{-- {{dd(Session::get('success'))}} --}}
        @foreach (Session::get('success') as $msg)
        <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{$msg}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>
        @endforeach

       {{Session::forget('success')}}

    @endif
    @if(Session::has('primary'))
        {{-- {{dd(Session::get('success'))}} --}}
        @foreach (Session::get('primary') as $msg)
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                {{$msg}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>
        @endforeach

       {{Session::forget('primary')}}

    @endif
    @if(Session::has('danger'))
        {{-- {{dd(Session::get('success'))}} --}}
        @foreach (Session::get('danger') as $msg)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$msg}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>
        @endforeach

       {{Session::forget('danger')}}

    @endif
</div>
