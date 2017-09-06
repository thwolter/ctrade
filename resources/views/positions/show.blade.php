@extends('layouts.master')

@section('content')

<div>
   <portlet title="{{ $position->positionable->name }}">
      <div class="col-md-3">
         <p><span>ISIN: </span>{{ $position->positionable->isin }}</p>
         <p><span>WKN: </span>{{ $position->positionable->wkn }}</p>
      </div>
     <div class="col-md-3">
        {{ $position->present()->price() }}
     </div>
   </portlet>
</div>

@endsection


