@extends('layouts.main')

@section('content')


    <header class="section-header">
            <div class="tbl">
                <div class="tbl-row">
                    <div class="tbl-cell">
                    <h2>Subscribers to '{{$newsletter->name}}'' </h2>
                        {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
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
                            <form action="/subscribers/{{$subscribers->id}}" method="POST">
                                @csrf
                                @method('DELETE')
                            <td><button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button></td>
                            </form>
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
				responsive: true
			});
		});
    </script>
@endsection
@endsection
