
<div class='notifications top-right'>
    {{-- {{dd(Session()->all())}} --}}
    {{-- {{Session::forget('success')}} --}}
    @if(Session::has('success'))
        {{-- {{dd(Session::get('success'))}} --}}
        @foreach (Session::get('success') as $msg)
        <div class="alert alert-success alert-dismissible fade show" id="success-alert" role="alert">
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
        <div class="alert alert-primary alert-dismissible fade show" id="primary-alert" role="alert">
                {{$msg}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
          </div>
        @endforeach

       {{Session::forget('primary')}}

    @endif
</div>

<script>

  @if(Session::has('info'))

      $('.top-right').notify({

        message: { text: "{{ Session::get('info') }}" },

        type:'info'

      }).show();

      @php

        Session::forget('info');

      @endphp

  @endif


  @if(Session::has('warning'))

  		$('.top-right').notify({

        message: { text: "{{ Session::get('warning') }}" },

        type:'warning'

      }).show();

      @php

        Session::forget('warning');

      @endphp

  @endif


  @if(Session::has('error'))

  		$('.top-right').notify({

        message: { text: "{{ Session::get('error') }}" },

        type:'danger'

      }).show();

      @php

        Session::forget('error');

      @endphp

  @endif


</script>
