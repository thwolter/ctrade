@role('admin')
<!-- Account -->
<li class="nav-item dropdown g-mx-20--lg">
    <a href="#" class="nav-link dropdown-toggle g-px-0" id="nav-link-1" aria-haspopup="true"
       aria-expanded="false" aria-controls="section-home-submenu" data-toggle="dropdown"
       data-appear-speed="200" data-appear-easing="linear">Admin

    </a>
    <ul class="dropdown-menu font-weight-normal rounded-0 g-text-transform-none g-brd-none g-brd-top g-brd-primary g-brd-top-1 g-mt-20 g-mt-10--lg--scrolling"
        id="nav-submenu-1" aria-labelledby="nav-link-1">
        <li class="active g-mx-5--lg">
            <a target="_blank" class="nav-link g-color-primary--hover" href="/admin/dashboard">
                Backpack
            </a>
        </li>
        <li class="g-mx-5--lg">
            <a target="_blank" class="nav-link g-color-primary--hover" href="/horizon">
                Horizon
            </a>
        </li>
    </ul>
</li>
@endrole