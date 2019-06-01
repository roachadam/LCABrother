
<script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
<link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
<script type="text/javascript" src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.js") }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/css/bootstrap-notify.css") }}">

<div class='notifications top-right'></div>


<script>


  @if(Session::has('success'))

     $('.top-right').notify({

        message: { text: "{{ Session::get('success') }}" }

      }).show();

     @php
       //dump(Session::get('success'));
       Session::forget('success');
     @endphp

  @endif


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
