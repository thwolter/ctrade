<div class="icon-stat">

    @php $signClass = ($value[0] === '-') ? 'negative' : '' @endphp
    <div class="row">
        <div class="col-xs-8 text-left">
            <span class="icon-stat-label">{{ $label }}</span> <!-- /.icon-stat-label -->
            <span class="icon-stat-value {{ $signClass }}">{{ $value }}</span> <!-- /.icon-stat-value -->
        </div><!-- /.col-xs-8 -->

        {{--<div class="col-xs-4 text-center">
            <i class="fa {{ $icon }} icon-stat-visual {{ $iconColor }}"></i> <!-- /.icon-stat-visual -->
        </div>--}}
    </div>

    <div class="icon-stat-footer">
        <i class="fa fa-clock-o"></i> Updated {{ $date }}
    </div>

</div> <!-- /.icon-stat -->
