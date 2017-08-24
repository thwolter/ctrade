@if (session('success') || isset($success))
    <div class="alert alert-success">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('success', isset($success) ? $success : null) }}
    </div>
@endif


@if(session('info') || isset($info))
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('info', isset($info) ? $info : null) }}
    </div>
@endif


@if(session('warning') || isset($warning))
    <div class="alert alert-warning">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('warning', isset($warning) ? $warning : null) }}
    </div>
@endif


@if(session('danger') || isset($danger))
    <div class="alert alert-danger">
        <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
        {{ session('danger', isset($danger) ? $danger : null) }}
    </div>
@endif