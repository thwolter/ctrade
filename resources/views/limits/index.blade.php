@extends('layouts.master')

@section('content-main')

    <!-- Create New Limit -->
    @component('layouts.components.section-1')
        @slot('title')
            Neues Limit einrichten
        @endslot

        <create-limit
                :portfolio="{{ $portfolio }}"
                route="{{ route('limits.store') }}">
        </create-limit>

    @endcomponent


    <!-- Loop over existing limits -->
    @foreach($limits as $limit)

        @component('layouts.components.section')

            @slot('id')
                limit_{{ $limit->id }}
            @endslot

            @slot('title')
                {{ $limit->present()->type() }} {{ $limit->present()->utilisation() }}
            @endslot

            @slot('subtitle')
                <a href="#">bearbeiten</a>
            @endslot
                Limit Panel
        @endcomponent

    @endforeach

    <div class="g-mb-60">
        {{ $limits->links('layouts.pagination.default-1') }}
    </div>

@endsection




@section('link.header')

@endsection




@section('script.footer')

@endsection