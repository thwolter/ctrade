@role('admin')

@component('layouts.components.sub-appbar')
    @slot('title')
        Admin
    @endslot

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

@endcomponent

@endrole
