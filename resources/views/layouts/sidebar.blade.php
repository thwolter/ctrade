<nav class="sidebar">
    <div class="sidebar-nav">
        <div class="sidebar-header">

            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>


        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            @if (Auth::check())
                <ul class="nav navbar-nav">

                    <span class="sidebar-nav--sub-title">Meine Portfolios</span>
                    @php($portfolios = auth()->user()->portfolios)

                    @foreach($portfolios as $portfolio)
                        <li class="">
                            <a href="{{ route('portfolios.show', $portfolio->id) }}">{{ $portfolio->name }}</a>
                        </li>
                    @endforeach

                    <li><a href="{{ route('portfolios.create') }}">+ Neues Portfolios</a></li>

                </ul>

            @endif


        </div>
    </div>
</nav>