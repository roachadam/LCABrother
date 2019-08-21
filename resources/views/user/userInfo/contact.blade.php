@extends('layouts.main')
@section('title', 'Member Contact Info')
@section('content')
    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">Member Contact Info</h2>
                    {{-- <div class="ml-auto" id="headerButtons">
                        This is where buttons should go if we need them
                    </div> --}}
                </div>
            </header>
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                </tr>
                </thead>
                <tbody>

                    @if ($members->count())

                        @foreach ($members as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email  }}</td>
                                <td>{{ $member->phone  }}</td>
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
