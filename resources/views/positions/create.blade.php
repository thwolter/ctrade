@extends('portfolios.show')

@section('container-content')

    <!-- Form with method  -->
    {!! Form::open(['route' => ['positions.search', $portfolio->id], 'method' => 'Get']) !!}

        <input type="hidden" name="portfolio_id" value="{{ $portfolio}}">

        @include('layouts.errors')

       <!-- search form input -->
       <div class="form-group">
           {!! Form::label('search', 'Suchen:') !!}
           {!! Form::text('search', null, ['placeholder' => 'Search ...', 'class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::submit('Suchen', ['class' => 'button--right']) !!}
        </div>


    {!! Form::close() !!}


@endsection


