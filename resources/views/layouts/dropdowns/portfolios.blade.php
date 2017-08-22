<li class="dropdown portfolio-dropdown {{ active_class(if_route_pattern(['portfolios.index'])) }}">

    <a href="javascript:;" class="dropdown-toggle portfolio-name" data-toggle="dropdown"
       data-hover="dropdown">
        @if (if_route(['portfolios.index']))
            Meine Portfolios
        @elseif (isset($focus))
            {{ $focus }}
        @elseif (isset($portfolio))
            {{ $portfolio->name }}
        @else
            Meine Portfolios
        @endif
        <i class="mainnav-caret portfolio-caret"></i>
    </a>

    <ul class="dropdown-menu" role="menu">

        <!-- new portfolio -->
        <li>
            <a href="{{ route('portfolios.create') }}">
                <i class="fa fa-edit dropdown-icon "></i>
                Neues Portfolio
            </a>
        </li>

        <!-- overview -->
        <li>
            <a href="{{ route('portfolios.index') }}">
                <i class="fa fa-th dropdown-icon "></i>
                Übersicht
            </a>
        </li>

        <!-- portfolios -->
        @if (Auth::user()->portfolios->count())
            <div class="separator"></div>
        @endif

        @foreach (Auth::user()->portfolios as $items)
            <li>
                <a href="{{ route('portfolios.show', $items->slug) }}">
                    <i class="fa fa-caret-right dropdown-icon "></i>
                    {{ $items->name }}
                </a>
            </li>
        @endforeach

    </ul>
</li>
