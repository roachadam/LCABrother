@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                        <h2>Subscribers to '{{$newsletter->name}}'' </h2>
                    </div>
                </div>
            </div>
        </header>
        <section class="card">
		<div class="card-block">
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Manage</th>
                </tr>
                </thead>
                <tbody>

                    @if ($subscribersz->count())
                        @foreach ($subscribersz as $subscribers)
                            <tr>
                                <td>{{ $subscribers->user->name }}</td>
                                <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#{{$subscribers->id}}">Delete</button></td>
                            </tr>

                            <!--.modal for confirming deletion-->
                            <div class="modal fade" id="{{$subscribers->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                                <i class="font-icon-close-2"></i>
                                            </button>
                                            <h4 class="modal-title" id="myModalLabel">Delete Subscriber</h4>
                                        </div>
                                        <form action="/subscribers/{{$subscribers->id}}" method="POST" class="box" >
                                            <div class="modal-body">
                                                @csrf
                                                @method('DELETE')
                                                <div class="col-md-12">
                                                    <p>Are you sure you want to delete this subscriber?</p>
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
				responsive: true
			});
		});
    </script>
@endsection
@endsection
