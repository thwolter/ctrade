@if (session('delete_portfolio'))
    <div class="alert alert-warning">
        <strong>Achtung:</strong> Portfolio wird einschließlich der historischen Wertentwicklung
        unwiderruflich gelöscht. Zum Fortfahren bitte am Ende der Seite bestätigen.
    </div>

@endif

@include('partials.errors')

<h2 class="h4 g-font-weight-300">Portfolio Einstellungen</h2>

<p class="g-mb-25">
    Allgemeine Angaben zu deinem Portfolio.
</p>

{!! Form::open(['route' => ['portfolios.update', $portfolio->slug], 'method' => 'PUT',
 'class' => 'g-brd-gray-light-v4 g-pa-30 g-mb-30']) !!}

<input type="hidden" name="tab" value="portfolio">
<input type="hidden" name="id" value="{{ $portfolio->id }}">


<!-- Portfolio name -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10" for="name">Portfolio Name</label>
    <div class="col-sm-9">
        <input type="text" id="name" name="name" value="{{ $portfolio->name }}"
               class="form-control u-form-control rounded-0">
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Wie möchtest du dein Portfolio benennen?
        </small>
    </div>
</div>


<!-- Portfolio desctiption -->
<div class="form-group row g-mb-25">
    <label class="col-sm-3 col-form-label g-mb-10">Beschreibung</label>
    <div class="col-sm-9">
            <textarea id="description-textarea" name="description" rows="6" class="form-control"
                      placeholder="Beschreiben dein Portfolio">{{ $portfolio->description }}</textarea>
        <small class="form-text text-muted g-font-size-default g-mt-10">
            Notizen zu deinem Portfolio
        </small>
    </div>
</div>

<hr class="g-brd-gray-light-v4 g-my-25">

<!-- Buttons -->
<div class="text-sm-right">
    <button type="submit" class="btn u-btn-darkgray rounded-0 g-py-12 g-px-25 g-mr-10">Speichern</button>
</div>

{!! Form::close() !!}

{!! Form::open([
    'route' => ['portfolios.destroy', $portfolio->slug],
    'method' => 'DELETE',
    'class' => 'form form-horizontal'
    ]) !!}

@if (!session('delete'))
    <div class="form-group">
        {{--<label class="col-md-3 control-label">Portfolio löschen</label>--}}
        <div class="col-md-7">
            <button type="submit" class="btn btn-link">Portfolio löschen</button>
        </div>
    </div>
@else
    <div class="form-group">
        <div class="col-md-7 col-md-push-3">

            <button type="submit" class="btn btn-danger">Portfolio unwiderruflich löschen</button>
            <input type="hidden" name="confirmed" value="true">

            <p style="margin-top: 20px;">
                <a href="{{ route('portfolios.edit', $portfolio->slug) }}" class="">Nein, nicht löschen.</a>
            </p>
        </div>
    </div>
    @php(session()->forget('delete'))
@endif
{!! Form::close() !!}

