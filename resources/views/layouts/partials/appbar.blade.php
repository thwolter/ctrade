<div class="navbar navbar-default" role="navigation">

    <div class="container">


        <div class="navbar-header">
            <div class="navbar-brand">
                <a href="index.html" class="logo">
                    <img src="http://metarocket.space/mockups/mvpready-2.3.2/templates/admin/img/logo.png" alt="">
                </a>
            </div>

            <button class="navbar-toggle pull-right" type="button" data-toggle="collapse"
                    data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <i class="fa fa-cog"></i>
            </button>
        </div><!-- /.navbar-header -->

        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">

                <li class="divider"></li>

                <li class="dropdown navbar-profile">

                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="javascript:;">
                        Mein Account
                        <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu" role="menu">

                        <!-- My profil -->
                        <li><a href="{{ route('users.edit', Auth()->id()) }}">
                            <i class="fa fa-user"></i> Mein Profil
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

            <!-- page links -->
            <ul class="nav  navbar-nav navbar-right">
                <li class="navbar-item">
                    <a href="javsacript:;">Blog</a>
                </li>

                <li class="navbar-item">
                    <a href="javsacript:;">Kontakt</a>
                </li>

                <li class="navbar-item">
                    <a href="javsacript:;">Über uns</a>
                </li>

            </ul>

            <!-- portfolio menu -->
            <ul class="nav navbar-nav navbar-left">

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="javascript:;">
                        Portfolios
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="#">
                                <i class="fa fa-edit dropdown-icon "></i>
                                Neues Portfolio
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="fa fa-edit dropdown-icon "></i>
                                Übersicht
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="navbar-divider"></li><!-- /.navbar-divider -->

                <!-- notifications -->
                <li class="dropdown navbar-notification">

                    <a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown"
                       data-hover="dropdown">
                        <i class="fa fa-bell navbar-notification-icon"></i>
                        <span class="visible-xs-inline">&nbsp;Notifications</span>
                        @php
                            $count = count(Auth::user()->unreadNotifications)
                        @endphp
                        @if ($count)
                            <b class="badge badge-primary">{{ $count }}</b>
                        @endif
                    </a>

                    <div class="dropdown-menu">

                        <div class="dropdown-header">&nbsp;Notifications</div>

                        <div class="notification-list">

                            @foreach(Auth::user()->unreadNotifications as $notification)

                                @include ('notifications.unread.'.snake_case(class_basename($notification->type)))
                                @php $notification->markAsRead() @endphp

                            @endforeach

                        </div> <!-- / .notification-list -->

                        <a href="{{ route('notifications.index') }}" class="notification-link">Alle
                            Benachichtigungen</a>

                    </div> <!-- / .dropdown-menu -->

                </li>

                <!-- second notifications -->
                <li class="dropdown navbar-notification">

                    <a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown"
                       data-hover="dropdown">
                        <i class="fa fa-envelope navbar-notification-icon"></i>
                        <span class="visible-xs-inline">&nbsp;Messages</span>
                    </a>

                    <div class="dropdown-menu">

                        <div class="dropdown-header">Messages</div>

                        <div class="notification-list">

                            <a href="./page-notifications.html" class="notification">
                                <div class="notification-icon"><img
                                            src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-3-md.jpg') }}"
                                            alt=""></div>
                                <div class="notification-title">New Message</div>
                                <div class="notification-description">Praesent dictum nisl non est sagittis luctus.
                                </div>
                                <div class="notification-time">20 minutes ago</div>
                            </a> <!-- / .notification -->

                            <a href="./page-notifications.html" class="notification">
                                <div class="notification-icon"><img
                                            src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-3-sm.jpg') }}"
                                            alt=""></div>
                                <div class="notification-title">New Message</div>
                                <div class="notification-description">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit...
                                </div>
                                <div class="notification-time">20 minutes ago</div>
                            </a> <!-- / .notification -->

                            <a href="./page-notifications.html" class="notification">
                                <div class="notification-icon"><img
                                            src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-4-md.jpg') }}"
                                            alt=""></div>
                                <div class="notification-title">New Message</div>
                                <div class="notification-description">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit...
                                </div>
                                <div class="notification-time">20 minutes ago</div>
                            </a> <!-- / .notification -->

                            <a href="./page-notifications.html" class="notification">
                                <div class="notification-icon"><img
                                            src="{{ asset('vendor/mvp-theme/global/img/avatars/avatar-5-md.jpg') }}"
                                            alt=""></div>
                                <div class="notification-title">New Message</div>
                                <div class="notification-description">Lorem ipsum dolor sit amet, consectetur
                                    adipisicing elit...
                                </div>
                                <div class="notification-time">20 minutes ago</div>
                            </a> <!-- / .notification -->

                        </div> <!-- / .notification-list -->

                        <a href="./page-notifications.html" class="notification-link">View All Messages</a>

                    </div> <!-- / .dropdown-menu -->

                </li>

                <!-- third notifications -->
                <li class="dropdown navbar-notification empty">

                    <a href="./page-notifications.html" class="dropdown-toggle" data-toggle="dropdown"
                       data-hover="dropdown">
                        <i class="fa fa-warning navbar-notification-icon"></i>
                        <span class="visible-xs-inline">&nbsp;&nbsp;Alerts</span>


                    </a>

                    <div class="dropdown-menu">

                        <div class="dropdown-header">Alerts</div>

                        <div class="notification-list">

                            <h4 class="notification-empty-title">No alerts here.</h4>
                            <p class="notification-empty-text">Check out what other makers are doing on Explore!</p>

                        </div> <!-- / .notification-list -->

                        <a href="./page-notifications.html" class="notification-link">View All Alerts</a>

                    </div> <!-- / .dropdown-menu -->

                </li>

                <li class="navbar-divider"></li><!-- /.navbar-divider -->

            </ul>

        </div>

    </div> <!--/.container -->

</div> <!--/.navbar -->