@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{str_replace(url('/'), '', url()->previous())}}">Members</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alumni</li>
    </ol>
</nav>

<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Alumni</h2>
                <div class="ml-auto" id="headerButtons">
                    <a href="/alumni/contact" class="btn btn-inline btn-primary-outline">Contact Alumni</a>
                </div>
            </div>
        </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Alumniship Date</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>

                    @if ($alumni->count())
                        @foreach ($alumni as $alum)
                        <tr>
                            <td>{{ $alum->name }}</td>
                            <td>{{ $alum->phone }}</td>
                            <td>{{ $alum->email  }}</td>
                            <td>{{\Carbon\Carbon::parse($alum->updated_at)->toDayDateTimeString()}}</td>
                            @if (auth()->user()->canManageMembers())
                                <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$alum->id}}">Delete</button></td>

                                <!--.modal for confirming deletion-->
                                <div class="modal fade" id="{{$alum->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                    <i class="font-icon-close-2"></i>
                                                </button>
                                                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                            </div>
                                            <form action="/user/{{$alum->id}}/organization/remove" method="POST" class="box" >
                                                <div class="modal-body">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <p>Are you sure you want to remove alumni?</p>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-inline btn-danger">Delete</button>
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
@endsection
@endsection


