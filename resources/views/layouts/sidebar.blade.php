@if (Auth::check())
    <div class="list-group">
        @php($portfolios = auth()->user()->portfolios)

        @foreach($portfolios as $portfolio)
            <a href="{{ route('portfolios.show', $portfolio->id) }}"
               class="list-group-item {{ active_class(if_route_param('portfolio', $portfolio->id)) }}">

                {{ $portfolio->name }}
                <p>{{ $portfolio->present()->total() }}</p>

            </a>
        @endforeach

        <div class="center-block">
            <a href="{{ route('portfolios.create') }}" class="btn list-group-item">Neues Portfolios</a>
        </div>
    </div>
@endif