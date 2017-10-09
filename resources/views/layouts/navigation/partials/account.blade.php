<!-- Account -->
<li class="nav-item dropdown g-mx-20--lg">
    <a href="#" class="nav-link dropdown-toggle g-px-0" id="nav-link-1" aria-haspopup="true"
       aria-expanded="false" aria-controls="section-home-submenu" data-toggle="dropdown"
       data-appear-speed="200" data-appear-easing="linear">Account

    </a>
    <!-- Submenu (Bootstrap) -->
    <ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
        id="nav-submenu-1" aria-labelledby="nav-link-1">

        <li class="active g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'profile']) }}">
                Mein Profil
            </a>
        </li>

        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'password']) }}">
                Passwort
            </a>
        </li>

        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                Emails
            </a>
        </li>

        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                Emails
            </a>
        </li>

        <li class="g-mx-5--lg">
            <a class="nav-link g-color-primary--hover" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
        </form>
    </ul>
    <!-- End Submenu (Bootstrap) -->
</li>