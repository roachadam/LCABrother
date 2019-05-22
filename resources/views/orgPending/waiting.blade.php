@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Organization Pending') }}</div>


                <div class="card-body">
                    <h2>Your organization '{{ Auth::user()->organization->name }}' needs to verify your membership before proceeding.</h2>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
