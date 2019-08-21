@extends('layouts.main')
@section('title', 'Add Invite')
@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$event->name}}: Add Invite</div>
                <div class="card-body">
                    <form method="POST" action={{route('invite.store', $event)}}>
                        @csrf
                        <div class="form-group row"> {{-- Name --}}
                            <label for="guest_name" class="col-md-4 col-form-label text-md-right">{{ __('Guest Name') }}</label>

                            <div class="col-md-4">
                                <input id="guest_name" type="text" class="form-control " name="guest_name" value="{{ old('guest_name') }}" required autocomplete="guest_name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Invite') }}
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
