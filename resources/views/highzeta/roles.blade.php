@extends('main.dash')

@section('content')

<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Roles</h2>
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

                @if ($roles->count())

                @foreach ($roles as $role)
                <tr>
                    <th>{{ $role->name }}</th>
                    <th><button type="button" class="btn btn-inline btn-primary btn-sm ladda-button" data-toggle="modal" data-target="#editRole">Edit</button></th>
                    <input type="hidden" id="roleId" name="roleId" value="{{$role->id}}">
                </tr>
                @endforeach

                @endif

            </tbody>

        </table>
        {{-- todo: fix alignment --}}
        <button type="button" class="btn btn-inline btn-primary" data-toggle="modal" data-target="#addRole">
                Add Role
        </button>
    </div>
    <div class="modal fade"
        id="addRole"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                        <i class="font-icon-close-2"></i>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Add Role</h4>
                </div>
                <form method="POST" action="/organizations/{{ $org->id }}/roles" class="box" >
                    <div class="modal-body">

                        @csrf

                        <div class="col-md-12">
                            <fieldset class="form-group">
                                <label class="form-label semibold" for="name">Role Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="President" required>
                            </fieldset>

                            <label class="form-label semibold" for="exampleInput">Permissions</label>

                            {{-- edit member details --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="manage_member_details">
                                <label for="manage_member_details">Manage Member Details</label>
                            </div>
                            {{-- view all member service hour logs and edit/remove them --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="manage_all_service">
                                <label for="manage_all_service">Manage Service Event Logs</label>
                            </div>
                            {{-- view all member involvement(points) logs and edit/remove them,AND log them --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="manage_all_involvement">
                                <label for="manage_all_involvement">Manage Involvement</label>
                            </div>
                            {{-- view everyones service hours --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="view_all_service">
                                <label for="view_all_service">View Member's Service Hours</label>
                            </div>
                            {{-- view everyones involvement(points) --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="view_all_involvement">
                                <label for="view_all_involvement">View Member's Involvement</label>
                            </div>

                            {{-- // view all members --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="view_member_details">
                                <label for="view_member_details">View Members</label>
                            </div>
                            {{-- // log service hours --}}
                            <div class="checkbox-toggle">
                                <input type="checkbox" id="log_service_event">
                                <label for="log_service_event">Log Service Hours</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-inline btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!--.modal-->

    <div class="modal fade"
    id="editRole"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel">Edit Role</h4>
            </div>
            <form method="POST" action="/organizations/{{ $org->id }}/roles/update" class="box" >
                <div class="modal-body">
                    @csrf

                    <div class="col-md-12">
                        <fieldset class="form-group">
                            <label class="form-label semibold" for="name">Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ }}" placeholder="President" required>
                        </fieldset>

                        <label class="form-label semibold" for="exampleInput">Permissions</label>

                        {{-- edit member details --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="manage_member_details">
                            <label for="manage_member_details">Manage Member Details</label>
                        </div>
                        {{-- view all member service hour logs and edit/remove them --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="manage_all_service">
                            <label for="manage_all_service">Manage Service Event Logs</label>
                        </div>
                        {{-- view all member involvement(points) logs and edit/remove them,AND log them --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="manage_all_involvement">
                            <label for="manage_all_involvement">Manage Involvement</label>
                        </div>
                        {{-- view everyones service hours --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="view_all_service">
                            <label for="view_all_service">View Member's Service Hours</label>
                        </div>
                        {{-- view everyones involvement(points) --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="view_all_involvement">
                            <label for="view_all_involvement">View Member's Involvement</label>
                        </div>

                        {{-- // view all members --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="view_member_details">
                            <label for="view_member_details">View Members</label>
                        </div>
                        {{-- // log service hours --}}
                        <div class="checkbox-toggle">
                            <input type="checkbox" id="log_service_event">
                            <label for="log_service_event">Log Service Hours</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-inline btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->
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

    <script>

    </script>
    @endsection

@endsection
