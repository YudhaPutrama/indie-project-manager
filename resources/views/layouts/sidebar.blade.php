@if(Auth::user()->hasRole('admin')||Auth::user()->hasRole('staff'))
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        {{--Dashboard--}}
        <li class="start {{ Route::is('dashboard')?'active open':'' }}">
            <a href="{{ url('/') }}">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="{{ Route::is('profile')?'active open':'' }}">
            <a href="{{ url('/profile') }}">
                <i class="icon-user"></i>
                <span class="title">Profile</span>
            </a>
        </li>
        <li class="{{ Route::is('projects')?'active open':'' }}">
            <a href="{{ url('/projects') }}">
                <i class="icon-briefcase"></i>
                <span class="title">Projects</span>
            </a>
        </li>
        <li class="{{ Route::is('schedule')?'active open':'' }}">
            <a href="{{ url('/schedule') }}">
                <i class="icon-calendar"></i>
                <span class="title">Schedule</span>
            </a>
        </li>
        @if(Auth::user()->hasRole('admin'))
            <li class="{{ Route::is('users')?'active open':'' }}">
                <a href="{{ url('/users') }}">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
                </a>
            </li>
        @endif
        @if(isset($projects))
        <li class="heading">
            <h3 class="uppercase">Featured Project</h3>
        </li>

        @foreach($projects as $project)
        <li>
            <a href="#">
                <i class="icon-book-open"></i>
                <span class="title">Yearbook</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="{{ "/projects/".$project['id'] }}">
                        <i class="icon-briefcase"></i>
                        Details</a>
                </li>
                {{--<li>--}}
                    {{--<a href="{{ url(route('project-gallery',['id'=>$project['id']])) }}">--}}
                        {{--<i class="icon-frame"></i>--}}
                        {{--Gallery</a>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ url('/review') }}">
                        <i class="icon-tag"></i>
                        Review</a>
                </li>
                <li>
                    <a href="{{ url('/schedule') }}">
                        <i class="icon-calendar"></i>
                        Schedule</a>
                </li>
                <li>
                    <a href="{{ url('/edit') }}">
                        <i class="icon-pencil"></i>
                        Edit</a>
                </li>
            </ul>
        </li>
        @endforeach
        @endif
    </ul>
    <!-- END SIDEBAR MENU -->
</div>
@else
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <li>
                <a href="{{ url('/profile') }}">
                    <i class="icon-user"></i>
                    <span class="title">Profile</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/project') }}">
                    <i class="icon-briefcase"></i>
                    <span class="title">Projects</span>
                </a>
            </li>
            <li>
                <a href="{{ url('/schedule') }}">
                    <i class="icon-calendar"></i>
                    <span class="title">Schedule</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
@endif
