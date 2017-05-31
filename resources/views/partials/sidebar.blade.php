@if (Auth::check())
    <div>

        @php($portfolios = auth()->user()->portfolios)

        @foreach($portfolios as $portfolio)
            <div class="card">
                <div class="card-block {{ active_class(if_route_param('portfolio', $portfolio->id)) }}">
                    <a href="{{ route('portfolios.show', $portfolio->id) }}">
                        <h5 class="card-title">{{ $portfolio->name }}</h5>
                    </a>
                    <p class="card-text">
                        <div class="container">
                            <dl class="row">
                                <dt class="col-sm-5">Gesamt:</dt>
                                <dd class="col-sm-7">{{ $portfolio->present()->total() }}</dd>
                            </dl>
                        </div>
                    </p>
                    
                    <a href="{{ route('portfolios.show', $portfolio->id) }}" class="btn theme-btn-color">Öffnen</a>
                </div>
                
            </div>
            <div class="space-20"></div>
        @endforeach

        <div class="text-center">
            <button href="{{ route('portfolios.create') }}" class="btn btn btn-secondary">Neues Portfolios</button>
        </div>
    </div>
@endif