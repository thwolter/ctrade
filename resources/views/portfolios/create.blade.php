@extends('layouts.master')

@section('content')

    @php ($focus = 'Portfolio erstellen')

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <portlet title="Portfolio erstellen">

                    <div class="col-md-12">
                        <create-portfolio
                                route="{{ route('portfolios.store', [], true) }}"
                                :currencies="{{ json_encode($currencies) }}"
                                :categories="{{ json_encode($categories) }}">
                        </create-portfolio>
                    </div>

                </portlet> <!-- /portlet -->
            </div>

        </div>

@endsection
