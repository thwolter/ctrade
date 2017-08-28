@extends('layouts.errors')

    @php
        $page = 500;
        $title = trans('errorpages.500.title');
        $message = trans('errorpages.500.message');
    @endphp


@section('scripts.footer')

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

@endsection

