@role('admin')
<!-- Account -->
<li class="hs-has-sub-menu d-block d-md-inline-block g-pos-rel g-mx-4 g-mt-10">
    <a href="#" id="dropdown-invoker-3"
       class="g-color-white g-color-primary--hover g-text-underline--none--hover"
       aria-haspopup="true" aria-expanded="false" aria-controls="dropdown-3">ADMIN
    </a>
    <ul id="dropdown-3" class="hs-sub-menu list-unstyled g-bg-gray-dark-v1 g-py-10 g-px-20 g-mt-13"
        aria-labelledby="dropdown-invoker-3">

        <li class="g-py-10">
            <a href="/admin/dashboard"
               target="_blank" class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover" >
                Backpack
            </a>
        </li>
        <li class="g-py-10">
            <a href="/horizon"
               target="_blank" class="d-block g-text-underline--none--hover g-color-white g-color-primary--hover" >
                Horizon
            </a>
        </li>
    </ul>
</li>
@endrole