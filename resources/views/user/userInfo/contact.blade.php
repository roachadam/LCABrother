@extends('layouts.main')
@section('title', 'Member Contact Info')
@section('content')

    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                    <div class="row">
                            <h2 class="card-title">Members Contact Info</h2>
                            <div class="ml-auto" id="headerButtons">
                                <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#newMemModal">Invite New Members</button>
                                <a href="/alumni" class="btn btn-inline btn-primary-outline">View Alumni</a>

                            </div>
                        </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Zeta Number</th>
                    <th>Major</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    @if(auth()->user()->id === 1 || auth()->user()->id === 4)
                        <th>Edit</th>
                    @endif
                </tr>
                </thead>
                <tbody>

                    @if ($members->count())

                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>
                                    @if(isset($member->zeta_number))
                                        ΙΩ {{ $member->zeta_number }}
                                    @endif
                                </td>
                                <td>{{$member->major}}</td>
                                <td>{{ $member->email  }}</td>
                                <td>{{ $member->phone  }}</td>
                                @if(auth()->user()->id === 1 || auth()->user()->id === 4)
                                    <td><button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#editUser-{{$member->id}}">Edit</button></td>

                                    <!--.modal for Editing Event-->
                                    <div class="modal fade" id="editUser-{{$member->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                        <i class="font-icon-close-2"></i>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                                                </div>
                                                <form method="POST" action={{route('profile.update', $member)}} enctype="multipart/form-data" class="box" >
                                                    @csrf
                                                    <div class="modal-body">
                                                            <div class="form-group row">
                                                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name:') }}</label>

                                                                <div class="col-md-9">
                                                                    <input id="name" type="text" class="form-control " name="name" value="{{ $member->name }}" required autofocus>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="zeta_number" class="col-md-3 col-form-label text-md-right">{{ __('Zeta Number:') }}</label>

                                                                <div class="col-md-9">
                                                                    <input id="zeta_number" type="text" class="form-control " name="zeta_number" value="{{ $member->zeta_number }}" autofocus>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="major" class="col-md-3 col-form-label text-md-right">{{ __('Major:') }}</label>

                                                                <div class="col-md-9">
                                                                    <input id="major" type="text" class="form-control " name="major" value="{{ $member->major }}" required autofocus>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('Email:') }}</label>

                                                                <div class="col-md-9">
                                                                    <input id="email" type="text" class="form-control " name="email" value="{{ $member->email }}" required autofocus>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label for="phone" class="col-md-3 col-form-label text-md-right">{{ __('Phone Number:') }}</label>

                                                                <div class="col-md-9">
                                                                    <input id="phone" type="text" class="form-control " name="phone" value="{{ $member->phone }}" required autofocus>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" id="user" name="user" value={{$member->id}}>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-inline btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!--.modal-->
                                @endif
                            </tr>
                        @endforeach

                    @endif

                </tbody>
            </table>
        </div>
    </section>

<div class="modal fade" id="newMemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Invite New Members</h4>
            </div>
            <div class="card-block">
                <div id="alert_placeholder"></div>
                <p>
                    Share this link with members of your organization:

                    {{-- <input type="text" class="form-control" name="link2" id="link2" readonly value="{{env('APP_URL')}}/organizations/{{auth()->user()->organization->id}}/join"> --}}

                    <p id="link" aria-readonly="true"  class="form-control">
                        {{env('APP_URL')}}/organizations/{{auth()->user()->organization->id}}/join
                    </p>
                </p>
                <button type="submit" class="btn btn-primary" onclick="copyText()">Copy Link</button>

            </div>

        </div>
    </div>
</div><!--.modal-->

    @section('js')
        <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
        <script>
            $(function() {
                $('#table').DataTable({
                    responsive: true,
                    pageLength: 25
                });
            });
        </script>

<script>
        function copyText() {
            var range, selection, worked;
            var element = document.getElementById("link");
            if (document.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(element);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(element);
                selection.removeAllRanges();
                selection.addRange(range);
            }

            try {
                var successful = document.execCommand('copy');
                // alert('text copied');
                if(successful){
                    showalert('Copied to Clipboard!','-success')
                }
                else{
                    showalert('Failed to Copy','-error')
                }
            }
            catch (err) {
            }
        }
        function showalert(message,alerttype) {
            $('#alert_placeholder').append('<div id="alertdiv" class="alert alert' +  alerttype + '"><a class="close" data-dismiss="alert">×</a><span>'+message+'</span></div>')
            setTimeout(function() { // this will automatically close the alert and remove this if the users doesnt close it in 5 secs
                $("#alertdiv").remove();

                }, 5000);
            }
        </script>
    @endsection
@endsection
