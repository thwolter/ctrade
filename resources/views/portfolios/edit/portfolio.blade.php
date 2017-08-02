<div class="tab-pane fade in {{ active_tab(session('active'), 'portfolio') }}" id="portfolio">

    <div class="heading-block">
        <h3>
            Portfolio Einstellungen
        </h3>
    </div>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('delete'))
        <div class="alert alert-warning">
           <strong>Achtung:</strong> Portfolio wird einschließlich der historischen Wertentwicklung
            unwiderruflich gelöscht. Zum Fortfahren bitte am Ende der Seite bestätigen.
        </div>

    @endif

    @include('partials.errors')

    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula
        eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient
        montes.</p>

    <br><br>

    {!! Form::open(['route' => ['portfolios.update', $portfolio->id], 'method' => 'PUT',
     'class' => 'form form-horizontal']) !!}

    <input type="hidden" name="active" value="portfolio">
    <input type="hidden" name="id" value="{{ $portfolio->id }}">


    <!-- Portfolio name -->
    <div class="form-group">
        <label class="col-md-3 control-label">Portfolio Name</label>
        <div class="col-md-7">
            <input type="text" name="name" , value="{{ $portfolio->name }}" class="form-control">
        </div>
    </div>

    <!-- Portfolio category -->
    <div class="form-group">
        <label class="col-md-3 control-label">Kategorie</label>
        <div class="col-md-7">
            <input type="text" name="category" value="" class="form-control">
        </div>
    </div>

    <!-- Portfolio desctiption -->
    <div class="form-group">
        <label class="col-md-3 control-label">Beschreibung</label>
        <div class="col-md-7">
            <textarea id="description-textarea" name="description" rows="6" class="form-control">{{ $portfolio->description }}</textarea>
        </div>
    </div>

    <!-- Buttons -->
    <div class="form-group">
        <div class="col-md-7 col-md-push-3">
            <button type="submit" class="btn btn-primary">Speichern</button>
            <button type="reset" class="btn btn-default">Abbrechen</button>
        </div>
    </div>

    {!! Form::close() !!}

    <br><hr>
    {!! Form::open([
        'route' => ['portfolios.destroy', $portfolio->id],
        'method' => 'DELETE',
        'class' => 'form form-horizontal'
        ]) !!}

    @if (!session('delete'))
        <div class="form-group">
            <label class="col-md-3 control-label">Portfolio löschen</label>
            <div class="col-md-7">
                <button type="submit" class="btn btn-tertiary">Ja, Portfolio löschen</button>
            </div>
        </div>
    @else
        <div class="form-group">
            <div class="col-md-7 col-md-push-3">

                <button type="submit" class="btn btn-warning">Portfolio unwiderruflich löschen</button>
                <input type="hidden" name="confirmed" value="true">

                <p style="margin-top: 20px; font-size: 1.1em">
                    <a href="{{ route('portfolios.edit', $portfolio->id) }}" class="">Nein, nicht löschen.</a>
                </p>
            </div>
        </div>
        @php(session()->forget('delete'))
    @endif
    {!! Form::close() !!}

</div>