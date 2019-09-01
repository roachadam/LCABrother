
<div class="app__menu">
    <ul class="vMenu">
    <li><a href="/dash" class="{{Request::is('dash') ? 'vMenu--active' : ''}}" >Dashboard</a></li>
        <li><a href="/serviceEvent/create" class="{{Request::is('serviceEvent/create') ? 'vMenu--active' : ''}}">Submit Service Hours</a></li>
        <li><a href="/serviceEvent" class="{{Request::is('serviceEvent*') ? 'vMenu--active' : ''}}">View Service Events</a></li>
        <li><a href="/involvementLog" class="{{Request::is('involvementLog*') ? 'vMenu--active' : ''}}">View Involvement Scores</a></li>
        <li><a href="/users/contact" class="{{Request::is('users/contact') ? 'vMenu--active' : ''}}">View Contact Info</a></li>
        <li><a href="/event" class="{{Request::is('event*') ? 'vMenu--active' : ''}}">Events</a></li>
        @if (auth()->user()->canManageMembers())
            <li><a href="/role" class="{{Request::is('role') ? 'vMenu--active' : ''}}">Roles</a> </li>
        @endif
        @if (auth()->user()->canManageMembers())
            <li><a href="/user" class="{{Request::is('user*') ? 'vMenu--active' : ''}}">Member Overviews</a> </li>
        @endif
        @if (auth()->user()->canManageInvolvement())
            <li><a href="/involvement" class="{{Request::is('involvement*') ? 'vMenu--active' : ''}}">Submit Involvement Data</a> </li>
        @endif
        @if (auth()->user()->canManageMembers())
            <li><a href="/goals" class="{{Request::is('goals*') ? 'vMenu--active' : ''}}">Organization Goals</a> </li>
        @endif
        {{-- <li><a href="#" class="vMenu--active">Active page</a></li> --}}
    </ul>
</div>

