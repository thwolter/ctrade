@role('admin')
<ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
    id="nav-submenu-1" aria-labelledby="nav-link-1">
    <li class="active g-mx-5--lg">
        <a class="nav-link g-color-primary--hover" href="/admin/dashboard">
            Backpack
        </a>
    </li>
    <li class="g-mx-5--lg">
        <a class="nav-link g-color-primary--hover" href="/horizon">
            Horizon
        </a>
    </li>
    <li class="g-mx-5--lg">
        <a class="nav-link g-color-primary--hover"
           href="{{ route('users.edit', ['tab' => 'messaging']) }}">
            Emails
        </a>
    </li>
</ul>
@endrole