<div class="navbar navbar-default" role="navigation">

    <div class="container">


        <div class="navbar-header">
            @include('layouts.navigation.brand')

            <button class="navbar-toggle pull-right" type="button" data-toggle="collapse"
                    data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-cog"></i>
            </button>
        </div><!-- /.navbar-header -->

        <div class="navbar-collapse collapse">

            <!-- page links -->
            <ul class="nav navbar-nav navbar-small">

                <li class="navbar-divider"></li><!-- /.navbar-divider -->

                <li class="navbar-item">
                    <a href="{{ route('home.blog') }}">Blog</a>
                </li>

                <li class="navbar-item">
                    <a href="{{ route('home.contact') }}">Kontakt</a>
                </li>

                <li class="navbar-item">
                    <a href="{{ route('home.about') }}">Über uns</a>
                </li>

                <li class="navbar-divider"></li><!-- /.navbar-divider -->

            </ul>

            <ul>
            <!-- user menu -->
            <ul class="nav navbar-nav navbar-right">

                {{--<li class="divider"></li>--}}

                <li class="dropdown navbar-profile">

                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="#">
                        Mein Account
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu" role="menu">

                        <!-- My profil -->
                        <li><a href="{{ route('users.edit', ['tab' => 'profile']) }}">
                            <i class="fa fa-user"></i> Mein Profil
                        </a></li>

                        <!-- Password -->
                        <li><a href="{{ route('users.edit', ['tab' => 'password']) }}">
                                <i class="fa fa-lock"></i> Passwort
                            </a></li>

                        <!-- Messaging -->
                        <li><a href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                                <i class="fa fa-bullhorn"></i> Benachichtigungen
                            </a></li>

                        <!-- Admin dashboard -->
                        @role('admin')
                        <li><a href="/admin/dashboard">
                                <i class="fa fa-globe"></i> Dashboard
                            </a></li>
                        @endrole


                        <li class="divider"></li>

                        @if (Auth::guest())
                            <li><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li>

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i>
                                    Abmelden
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>

            </ul>

            <!-- notifications bar -->
            <ul class="nav navbar-nav navbar-right">
                <li class="navbar-divider"></li>

                <!-- notifications -->
                <notifications
                        :user_id="{{ Auth::user()->id }}"
                        :unread="{{ json_encode(Auth::user()->unreadNotifications) }}"
                        show_url="{{ route('notifications.index') }}"
                        icon="fa-envelope">
                </notifications>
            </ul>

            </ul>

        </div>

    </div> <!--/.container -->

</div> <!--/.navbar -->