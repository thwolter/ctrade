@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="space-70"></div>
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Hoppla!</h1>
                    <h2>
                        404 Not Found</h2>
                    <div class="error-details">
                        Seite nicht mehr verfügbar.
                    </div>
                    <div class="space-30"></div>
                    <div class="error-actions">

                        <a href="/" class="btn theme-btn-color btn-lg">
                            <i class="fa fa-home fa-fw" aria-hidden="true"></i>
                            Zur Homepage
                        </a>
                        <a href="#" class="btn theme-btn-color-outline btn-lg">
                            <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i>
                            Kontakt Support
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="space-70"></div>

    </div>


@endsection