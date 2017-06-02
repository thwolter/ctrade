<nav class="navbar navbar-toggleable-sm navbar-light bg-faded yamm">
    <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="index.html"><img src="{{ asset('img/logo-dark.png') }}" class="img-fluid" alt=""></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="#"> Über uns</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>

                @if (Auth::guest())
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @else
                    <li class=" dropdown nav-item">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">Mein Account</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                            <li><a class="dropdown-item" href="#">Einstellungen</a></li>

                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav><!--nav end-->