<li class="nav-item g-my-8 {{ active_class(if_route_pattern(['blog'])) }}">
    <a href="{{ route('blog.index') }}"
       class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
        Blog
    </a>
</li>

<li class="nav-item g-my-8 {{ active_class(if_route('home.contact')) }}">
    <a href="{{ route('home.contact') }}"
       class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
        Kontakt
    </a>
</li>

<li class="nav-item g-my-8 {{ active_class(if_route('home.about')) }}">
    <a href="{{ route('home.about') }}"
       class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
        Über uns
    </a>
</li>

<li class="nav-item g-my-8 {{ active_class(if_route('faq.index')) }}">
    <a href="{{ route('faq.index') }}"
       class="nav-link g-bg-primary-dark-v1--hover g-font-weight-600 g-font-size-default g-px-17 g-px-23--xl">
        FAQ
    </a>
</li>