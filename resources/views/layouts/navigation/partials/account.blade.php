<!-- Account -->
<li class="hs-has-sub-menu d-block d-md-inline-block g-pos-rel g-mx-4 g-mt-10">
    <a href="#" id="dropdown-invoker-3"
       class="g-color-white g-color-primary--hover g-text-underline--none--hover"
       aria-haspopup="true" aria-expanded="false" aria-controls="dropdown-3">ACCOUNT
    </a>
    <ul id="dropdown-3" class="hs-sub-menu list-unstyled g-bg-gray-dark-v1 g-py-10 g-px-20 g-mt-13"
        aria-labelledby="dropdown-invoker-3">

        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'profile']) }}">
                Mein Profil
            </a>
        </li>

        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'password']) }}">
                Passwort
            </a>
        </li>

        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
               href="{{ route('users.edit', ['tab' => 'messaging']) }}">
                Emails
            </a>
        </li>

        <li class="g-py-10">
            <a class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover"
               href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
        </li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
        </form>
    </ul>
</li>
