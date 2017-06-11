@extends('layouts.master')

@section('content')

    <div class="container">
        <div class="row">
            <div class="title">Something went wrong.</div>
        @unless(empty($sentryID))
            <!-- Sentry JS SDK 2.1.+ required -->
                <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

                <script>
                    Raven.showReportDialog({
                        eventId: '{{ $sentryID }}',

                        // use the public DSN (dont include your secret!)
                        dsn: 'https://962f2203bdb945a9be03e5d67e2935d5@sentry.io/178330'
                    });
                </script>
            @endunless
        </div>
        </div>


@endsection