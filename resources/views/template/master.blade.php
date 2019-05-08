@include('template.partials.header')
{{--navigation bar--}}
<nav class="navbar navbar-expand-sm navbar-dark bg-dark p-0">
    <div class="container">
        <a href="index.html" class="navbar-brand"><i class="fa fa-gear"></i> Control Panel</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item px-2">
                    <a id="nav-link-tag"href="{{route('tag.index')}}" class="nav-link">Tags</a>
                </li>
                <li class="nav-item px-2">
                    <a id="nav-link-user" href="{{route('user.index')}}" class="nav-link">Users</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item nav-link">

                    <i class="fa-fa-user"></i> Welcome  {{ Auth::user()->name }}

                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-forlarashopm').submit();">
                        <i class="fa fa-user-times"></i> Logout
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@yield('content')
@include('template.partials.footer')