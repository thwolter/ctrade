@extends('layouts.master')

@section('content')

    @php( $user = Auth::user() )
    @php( $portfolios = (is_null($user)) ? null : $user->portfolios )
    <div class="content">
        <div class="container">
            <br class="sm-50 md-100">

            <div class="error-container">

                <div class="error-code">404</div>

                <div class="error-details">

                    <h4>Oops, <span class="text-primary">You're lost</span>.</h4>

                    <p>We can not find the page you're looking for. Is there a typo in the url? Or try the search bar
                        below</p>

                    <form action="./page-404.html" class="form">

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div><!-- /input-group -->

                    </form>

                </div> <!-- /.error-details -->
            </div> <!-- /.error -->
        </div> <!-- /.container -->
    </div> <!-- .content -->

@endsection