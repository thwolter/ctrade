@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif


@if(session('info'))
    <div class="alert alert-success">{{ session('info') }}</div>
@endif


@if(session('warning'))
    <div class="alert alert-success">{{ session('warning') }}</div>
@endif


@if(session('danger'))
    <div class="alert alert-success">{{ session('danger') }}</div>
@endif