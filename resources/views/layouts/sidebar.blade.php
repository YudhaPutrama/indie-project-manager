@if(Auth::user()->isAdmin()||Auth::user()->isStaff())
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        {{--Dashboard--}}
        <li class="start {{ Route::is('dashboard')?'active open':'' }}">
            <a href="{{ url('/dashboard') }}">
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
        <li class="{{ Route::is('project')?'active open':'' }}">
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
        {{--<li class="{{ Route::is('gallery')?'active open':'' }}">--}}
            {{--<a href="{{ url('/gallery') }}">--}}
                {{--<i class="icon-book-open"></i>--}}
                {{--<span class="title">Gallery</span>--}}
            {{--</a>--}}
        {{--</li>--}}
        <li class="{{ Route::is('blogs')?'active open':'' }}">
            <a href="{{ url('/blog') }}">
                <i class="icon-speech"></i>
                <span class="title">Blog</span>
            </a>
        </li>
        @if(Auth::user()->isAdmin())
            <li class="{{ Route::is('users')?'active open':'' }}">
                <a href="{{ url('/users') }}">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
                </a>
            </li>
        @endif

        @foreach(Auth::user()->favorite_projects as $project)
            @if($loop->first)
                <li class="heading">
                    <h3 class="uppercase">Favorite Projects</h3>
                </li>
            @endif
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
                <a href="{{ url('/projects') }}">
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
            <li>
                <a href="{{ url('/blog') }}">
                    <i class="icon-speech"></i>
                    <span class="title">Blog</span>
                </a>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
@endif
