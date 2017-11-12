@extends('layouts.master')

@section('content')

    @include('layouts.partials.header')

    <div class="container g-pt-100 g-pb-20">
        <div class="row justify-content-between">

        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

            <!-- Main section -->
            <div class="col-lg-9 order-lg-2 g-mb-80">
                <h2>Implement create Stock</h2>
            </div>
            
        </div>
    </div>

@endsection




@section('link.header')

@endsection




@section('script.footer')

@endsection