@extends('layouts.main')

@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Event') }}</div>
                <div class="card-body">
                    <form method="POST" action="/event">
                        @csrf

                        <div class="form-group row"> {{-- Name --}}
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Event Name') }}</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{--date_of_event --}}
                            <label for="date_of_event" class="col-md-4 col-form-label text-md-right">{{ __('Date of Event') }}</label>

                            <div class="col-md-4">
                                <input id="date_of_event" type="text" class="form-control" name="date_of_event" value="{{ old('date_of_event') }}" required autocomplete="date_of_event" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{-- num_invites --}}
                            <label for="num_invites" class="col-md-4 col-form-label text-md-right">{{ __('Number Of Invites Per Member') }}</label>

                            <div class="col-md-4">
                                <input id="num_invites" type="text" class="form-control " name="num_invites" value="{{ old('num_invites') }}" required autocomplete="num_invites" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Event') }}
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
