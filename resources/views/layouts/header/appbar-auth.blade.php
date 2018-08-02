<li class="list-inline-item">
    <a id="account-dropdown-invoker-2"
       class="g-color-black g-color-primary--hover g-font-weight-400 g-text-underline--none--hover" href="#!"
       aria-controls="account-dropdown-2"
       aria-haspopup="true"
       aria-expanded="false"
       data-dropdown-event="hover"
       data-dropdown-target="#account-dropdown-2"
       data-dropdown-type="css-animation"
       data-dropdown-duration="300"
       data-dropdown-hide-on-scroll="false"
       data-dropdown-animation-in="fadeIn"
       data-dropdown-animation-out="fadeOut">
        {{ Auth::user()->email }}
    </a>
    <ul id="account-dropdown-2"
        class="list-unstyled u-shadow-v29 g-pos-abs g-bg-white g-width-160 g-pb-5 g-mt-5 g-z-index-2"
        aria-labelledby="account-dropdown-invoker-2">
        <li>
            <a class="d-block g-color-black g-color-primary--hover g-text-underline--none--hover g-font-weight-400 g-py-5 g-px-20"
               href="{{ route('users.edit') }}">
                Einstellungen
            </a>
        </li>
        <li>
            <a class="d-block g-color-black g-color-primary--hover g-text-underline--none--hover g-font-weight-400 g-py-5 g-px-20"
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>

        @role('admin')

        <li>
            <a class="d-block g-color-black g-color-primary--hover g-text-underline--none--hover g-font-weight-400 g-py-5 g-px-20"
               href="/admin/dashboard"
               target="_blank"
               class="nav-link g-color-text g-font-weight-600">
                Backpack
            </a>
        </li>

        <li>
            <a class="d-block g-color-black g-color-primary--hover g-text-underline--none--hover g-font-weight-400 g-py-5 g-px-20"
               href="/admin/dashboard"
               target="_blank"
               class="nav-link g-color-text g-font-weight-600">
                Backpack
            </a>
        </li>

        <li>
            <a class="d-block g-color-black g-color-primary--hover g-text-underline--none--hover g-font-weight-400 g-py-5 g-px-20"
               href="/horizon"
               target="_blank"
               class="nav-link g-color-text g-font-weight-600">
                Horizon
            </a>
        </li>

        @endrole

    </ul>
</li>