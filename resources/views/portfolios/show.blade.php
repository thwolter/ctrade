@extends('layouts.portfolio')

@section('container-content')

    <div class="key-figure">
        <label class="label">Aktuell</label>
        <span class="value">{{ $portfolio->present()->total() }}</span>
    </div>


@endsection