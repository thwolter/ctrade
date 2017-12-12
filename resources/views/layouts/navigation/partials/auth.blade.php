@guest
    <li class="nav-item g-my-8 g-mx-5">
        <a href="{{ route('login') }}"
           class="nav-link g-bg-gray-light-v2 g-color-gray-dark-v2 g-bg-gray-light-v4--hover g-font-weight-600 g-font-size-default g-px-17">
            Login
        </a>
    </li>

    <li class="nav-item g-my-8 g-mx-5">
        <a href="{{ route('register') }}"
           class="nav-link g-bg-primary g-bg-primary-opacity-0_6--hover g-font-weight-600 g-font-size-default g-px-17">
            Register
        </a>
    </li>
@endguest

@auth
    <li class="nav-item g-my-8 g-pos-rel">
        <a id="account-dropdown-invoker"
           class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl"
           href="#"
           aria-controls="account-dropdown"
           aria-haspopup="true"
           aria-expanded="false"
           data-dropdown-event="hover"
           data-dropdown-target="#account-dropdown"
           data-dropdown-type="css-animation"
           data-dropdown-duration="0"
           data-dropdown-hide-on-scroll="true"
           data-dropdown-animation-in="fadeIn"
           data-dropdown-animation-out="fadeOut">
            Account
            <i class="ml-2 fa fa-angle-down"></i>
        </a>

        <ul id="account-dropdown"
            class="list-unstyled u-shadow-v11 g-min-width-220 g-bg-white g-pos-abs g-left-0 g-z-index-99 g-mt-28"
            aria-labelledby="account-dropdown-invoker">

            <li class="dropdown-item g-px-5">
                <a class="nav-link g-color-text g-font-weight-600"
                   href="{{ route('users.edit') }}">
                    Einstellungen
                </a>
            </li>

            <li class="dropdown-item g-px-5">
                <a class="nav-link g-color-text g-font-weight-600"
                   href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </li>

            @role('admin')

            <li class="dropdown-item g-px-5">
                <a href="/admin/dashboard"
                   target="_blank"
                   class="nav-link g-color-text g-font-weight-600">
                    Backpack
                </a>
            </li>
            <li class="dropdown-item g-px-5">
                <a href="/horizon"
                   target="_blank"
                   class="nav-link g-color-text g-font-weight-600">
                    Horizon
                </a>
            </li>

            @endrole

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </ul>
    </li>
@endauth