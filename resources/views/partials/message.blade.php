@if (session('success') || isset($success))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('success', $success) }}
    </div>
@endif


@if(session('info') || isset($info))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('info', $info) }}
    </div>
@endif


@if(session('warning') || isset($warning))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('warning', $warning) }}
    </div>
@endif


@if(session('danger') || isset($danger))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('danger', $danger) }}
    </div>
@endif