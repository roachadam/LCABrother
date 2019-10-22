<nav class="side-menu">
    <ul class="side-menu-list">
        <li class="grey {{ request()->is('dash') ? 'opened' : '' }}">
            <a href="/dash">
                <i class="font-icon glyphicon glyphicon-home"></i>
                <span class="lbl ">Dashboard</span>
            </a>
        </li>
        <li class="green {{ request()->is('serviceEvent') ? 'opened' : '' }}">
                <a href="/serviceEvent">
                    <i class="font-icon glyphicon glyphicon-leaf"></i>
                    <span class="lbl">Service Events</span>
                </a>
        </li>
        <li class="blue {{ request()->is('serviceLogs') ? 'opened' : '' }}">
            <a href="/serviceLogs">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Service Logs</span>
            </a>
        </li>
        @if(auth()->user()->isActive())
            <li class="pink {{ request()->is('involvement') ? 'opened' : '' }}">
                <a href="/involvement">
                    <i class="glyphicon glyphicon-equalizer"></i>
                    <span class="lbl">Involvement</span>
                </a>
            </li>
        @endif
        <li class="blue {{ request()->is('users/contact') ? 'opened' : '' }}">
            <a href="/users/contact">
                <i class="glyphicon glyphicon-earphone"></i>
                <span class="lbl">Member Info</span>
            </a>
        </li>
        <li class="red {{ request()->is('event') ? 'opened' : '' }}">
            <a href="/event">
                <i class="glyphicon glyphicon-tasks "></i>
                <span class="lbl">Events</span>
            </a>
        </li>
        {{-- <li class="pink {{ request()->is('survey') ? 'opened' : '' }}">
            <a href="/survey">
                <i class=" glyphicon glyphicon-blackboard "></i>
                <span class="lbl">Surveys</span>
            </a>
        </li> --}}
        <li class="purple {{ request()->is('tasks') ? 'opened' : '' }}">
            <a href="/tasks">
                <i class="glyphicon glyphicon-list-alt"></i>
                <span class="lbl">Tasks</span>
            </a>
        </li>
        <li class="blue {{ request()->is('calendarItem') ? 'opened' : '' }}">
            <a href="/calendarItem">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Calendar</span>
            </a>
        </li>
        <li class="blue {{ request()->is('attendanceEvents') ? 'opened' : '' }}">
            <a href="/attendanceEvents">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Attendance</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu-list">
        @if (auth()->user()->canViewMembers())
            <header class="side-menu-title">High  Zeta</header>
            <li class="blue {{ request()->is('user') ? 'opened' : '' }}">
                <a href="/user">
                <span>
                    <i class="font-icon font-icon-users"></i>
                    <span class="lbl">Members</span>
                </span>
                </a>
            </li>
        @endif
        @if (auth()->user()->canManageInvolvement())
            <li class="pink {{ request()->is('involvement/events') ? 'opened' : '' }}">
                <a href={{route('involvement.events')}}>
                <span>
                    <i class="glyphicon glyphicon-list-alt"></i>
                    <span class="lbl">Involvement Events</span>
                </span>
                </a>
            </li>
        @endif
        @if (auth()->user()->canManageAllStudy())
            <li class="green {{ request()->is('academics') ? 'opened' : '' }}">
                <a href="/academics">
                <span>
                    <i class="glyphicon glyphicon-book"></i>
                    <span class="lbl">Academics</span>
                </span>
                </a>
            </li>
        @endif
        @if (auth()->user()->canManageMembers())
            <li class="purple {{ request()->is('role') ? 'opened' : '' }}">
                <a href="/role">
                <span>
                    <i class="glyphicon glyphicon-th-list"></i>
                    <span class="lbl">Roles</span>
                </span>
                </a>
            </li>
        @endif
        @if (auth()->user()->canManageGoals())
            <li class="red {{ request()->is('totals') ? 'opened' : '' }}">
                <a href="/totals">
                <span>
                    <i class="glyphicon glyphicon-book"></i>
                    <span class="lbl">Totals</span>
                </span>
                </a>
            </li>
        @endif
    </ul>
    {{-- <ul class="side-menu-list">
        <li class="green" style="position:fixed; bottom: 0; height:40px;">
            <button type="button" class="btn btn-block" data-toggle="modal" data-target="#ReportBugModal" style="background-color:transparent; border-color: transparent; box-shadow: none;">
                <i class="fa fa-bug"></i>
                <span class="lbl" style="padding-left: 35px;">Report a Bug</span>
            </button>
        </li>
    </ul> --}}
</nav><!--.side-menu-->


{{-- <div class="modal fade" tabindex="-1" role="dialog" id="ReportBugModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Bug Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method='POST' action="{{route('reportBug.send')}}" role="presentation" class="form">
                <div class="modal-body">
                    @csrf

                        <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="description" class="col-form-label text-md-right">What were you trying to do when the bug occured?</label>
                            <div class="input-group">
                                <textarea name="action" class="offset-1 form-control" id="description" cols="30" rows="5" placeholder="Attemping to submit service hours." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="description" class="col-form-label text-md-right">Describe the Bug</label>
                            <div class="input-group">
                                <textarea name="description" class="offset-1 form-control" id="description" cols="30" rows="5" placeholder="I got a 404 error when I clicked the submit button." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row col-md-12">
                            <label for="name" class="col-form-label text-md-right">URL Where Bug Occured</label>
                            <div class="input-group">
                                <input class="offset-1 form-control" type="text" name="url" id='name' value="{{url()->current()}}" required>
                            </div>
                        </div>
                    </div>
                    <input type="text" hidden value="{{auth()->user()->id}}" name="user_id">
                    <input type="text" hidden value="{{auth()->user()->organization->id}}" name="org_id">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                    <button type='submit' class="btn btn-inline btn-primary">Send Report</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}
