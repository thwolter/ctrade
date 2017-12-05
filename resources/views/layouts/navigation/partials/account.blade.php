
@component('layouts.components.sub-topbar')
    @slot('title')
        Account
    @endslot

    <li class="dropdown-item g-px-5">
        <a class="nav-link g-color-text g-font-weight-600"
           href="{{ route('users.edit', ['tab' => 'profile']) }}">
            Mein Profil
        </a>
    </li>

    <li class="dropdown-item g-px-5">
        <a class="nav-link g-color-text g-font-weight-600"
           href="{{ route('users.edit', ['tab' => 'password']) }}">
            Passwort
        </a>
    </li>

    <li class="dropdown-item g-px-5">
        <a class="nav-link g-color-text g-font-weight-600"
           href="{{ route('users.edit', ['tab' => 'messaging']) }}">
            Emails
        </a>
    </li>

    <li class="dropdown-item g-px-5">
        <a class="nav-link g-color-text g-font-weight-600"
           href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST"
          style="display: none;">
        {{ csrf_field() }}
    </form>

@endcomponent

