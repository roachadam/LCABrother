@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Organization Declined Membership</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Unfortunatly, you were rejected by the organization you attemped to register for.</p>

                    <p>Click the button below to register for another organization, or create your own.</p>
                    <div class="row">
                        <a href="/organization" class="btn btn-primary">Click Here</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
