@extends('layouts.main')
@section('title', 'Members')
@section('content')
<section class="card">
    <div class="card-block">
        <header class="card-header" style="border-bottom: 0">
            <div class="row">
                <h2 class="card-title">Manage Associates</h2>
                <div class="ml-auto" id="headerButtons">
                    <button type="button" class="btn btn-inline btn-primary-outline" data-toggle="modal" data-target="#allActive">Mark all as Active</button>
                </div>
            </div>
        </header>
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Service Hours</th>
                <th>Money Donated</th>
                <th>Points</th>
                <th>Manage</th>
            </tr>
            </thead>
            <tbody>

                @if ($getAssociateMembers->count())
                    @foreach ($getAssociateMembers as $associate)
                    <tr>
                        <td>{{ $associate->name }}</td>
                        <td>Associate</td>
                        <td> {{ $associate->getserviceHours() }} </td>
                        <td>$ {{ $associate->getMoneyDonated() }} </td>
                        <td> {{ $associate->getInvolvementPoints() }} </td>
                        <td><a href="/users/{{$associate->id}}/adminView" class="btn btn-inline">Manage</a></td>
                    </tr>
                    @endforeach
                @endif

            </tbody>
        </table>
    </div>
</section>


<div class="modal fade" id="allActive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Mark all Associates as Active</h4>
            </div>
            <form action="/user/{{$user->id}}/organization/remove" method="POST" class="box" >
                <div class="modal-body">
                    @csrf
                    <div class="col-md-12">
                        <p>Are you sure you want to mark all Associates as Actives?</p>
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
