<div class="content">
    <div class="container">
        <div class="portlet portlet-boxed">

            <div class="portlet-header">
                <h3 class="portlet-title"><u>{{ $title }}</u></h3>
            </div> <!-- /.portlet-header -->

            <div class="portlet-body">
                <div class="row">

                   {{ $slot }}

                </div> <!-- /.row -->
            </div> <!-- /.portlet-body -->
        </div> <!-- /.portlet -->
    </div>
</div>