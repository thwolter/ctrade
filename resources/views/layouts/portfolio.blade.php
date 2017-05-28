@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- sidebar navigation -->
            @include('layouts.sidebar')
        </div>

        <div class="col-md-9">
            <div class="panel panel-primary">

                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $portfolio->name }}
                        <span class="pull-right">
                            <a href="{{ route('portfolios.edit', $portfolio->id) }}">Einstellungen</a>
                        </span>
                    </h3>
                </div>

                <div class="panel-body">
                    @include('partials.pills')
                    @yield('container-content')
                </div>

                <!-- footer -->
                <div class="">

                </div>
            </div>
        </div>
    </div>
@endsection



