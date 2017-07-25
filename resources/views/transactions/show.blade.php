@extends('layouts.master_old')

@section('content')

    <div class="row">
        <div class="container">
            <p>Here goes awesome summary of {{ $transaction->id }}</p>
        </div>
    </div>

@endsection