<div class="content-page">

    <div class="content">

        @yield('content')

        <div class="container">

            <div class="row">

                <div class="col-md-3 col-sm-6">

                    <div class="icon-stat">

                        <div class="row">
                            <div class="col-xs-8 text-left">
                                <span class="icon-stat-label">Revenue</span> <!-- /.icon-stat-label -->
                                <span class="icon-stat-value">$5,367</span> <!-- /.icon-stat-value -->
                            </div><!-- /.col-xs-8 -->

                            <div class="col-xs-4 text-center">
                                <i class="fa fa-dollar icon-stat-visual bg-primary"></i> <!-- /.icon-stat-visual -->
                            </div><!-- /.col-xs-4 -->
                        </div><!-- /.row -->

                        <div class="icon-stat-footer">
                            <i class="fa fa-clock-o"></i> Updated Now
                        </div>

                    </div> <!-- /.icon-stat -->

                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">

                    <div class="icon-stat">

                        <div class="row">
                            <div class="col-xs-8 text-left">
                                <span class="icon-stat-label">Total Sales</span> <!-- /.icon-stat-label -->
                                <span class="icon-stat-value">473</span> <!-- /.icon-stat-value -->
                            </div><!-- /.col-xs-8 -->

                            <div class="col-xs-4 text-center">
                                <i class="fa fa-gift icon-stat-visual bg-secondary"></i> <!-- /.icon-stat-visual -->
                            </div><!-- /.col-xs-4 -->
                        </div><!-- /.row -->

                        <div class="icon-stat-footer">
                            <i class="fa fa-clock-o"></i> Updated Now
                        </div>

                    </div> <!-- /.icon-stat -->

                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">

                    <div class="icon-stat">

                        <div class="row">
                            <div class="col-xs-8 text-left">
                                <span class="icon-stat-label">Referrals</span> <!-- /.icon-stat-label -->
                                <span class="icon-stat-value">78</span> <!-- /.icon-stat-value -->
                            </div><!-- /.col-xs-8 -->

                            <div class="col-xs-4 text-center">
                                <i class="fa fa-exchange icon-stat-visual bg-tertiary"></i> <!-- /.icon-stat-visual -->
                            </div><!-- /.col-xs-4 -->
                        </div><!-- /.row -->

                        <div class="icon-stat-footer">
                            <i class="fa fa-clock-o"></i> Updated Now
                        </div>

                    </div> <!-- /.icon-stat -->

                </div> <!-- /.col-md-3 -->

                <div class="col-md-3 col-sm-6">

                    <div class="icon-stat">

                        <div class="row">
                            <div class="col-xs-8 text-left">
                                <span class="icon-stat-label">Inquiries</span> <!-- /.icon-stat-label -->
                                <span class="icon-stat-value">39</span> <!-- /.icon-stat-value -->
                            </div><!-- /.col-xs-8 -->

                            <div class="col-xs-4 text-center">
                                <i class="fa fa-envelope-o icon-stat-visual bg-default"></i> <!-- /.icon-stat-visual -->
                            </div><!-- /.col-xs-4 -->
                        </div><!-- /.row -->

                        <div class="icon-stat-footer">
                            <i class="fa fa-clock-o"></i> Updated Now
                        </div>

                    </div> <!-- /.icon-stat -->

                </div> <!-- /.col-md-3 -->

            </div> <!-- /.row -->


            <div class="row">

                <div class="col-md-4 col-sm-5">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Daily Stats
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body" style="min-height: 400px;">

                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit, fugiat, dolores,
                                laborum sit.</p>

                            <hr>

                            <table class="table keyvalue-table">
                                <tbody>
                                <tr>
                                    <td class="kv-key"><i class="fa fa-dollar kv-icon kv-icon-primary"></i> Revenue</td>
                                    <td class="kv-value">$5,367</td>
                                </tr>
                                <tr>
                                    <td class="kv-key"><i class="fa fa-gift kv-icon kv-icon-secondary"></i> Total Sales
                                    </td>
                                    <td class="kv-value">473</td>
                                </tr>
                                <tr>
                                    <td class="kv-key"><i class="fa fa-exchange kv-icon kv-icon-tertiary"></i>Referrals
                                    </td>
                                    <td class="kv-value">78</td>
                                </tr>
                                <tr>
                                    <td class="kv-key"><i class="fa fa-envelope-o kv-icon kv-icon-default"></i>
                                        Inquiries
                                    </td>
                                    <td class="kv-value">39</td>
                                </tr>
                                </tbody>
                            </table>

                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->


                <div class="col-md-8 col-sm-7">
                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Monthly Traffic
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body" style="min-height: 400px;">
                            <br class="xs-20">
                            <div id="line-chart" class="chart-holder-300"></div>
                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->

            </div> <!-- /.row -->


            <div class="row">

                <div class="col-md-5">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Product Breakdown
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">

                            <div id="pie-chart" class="chart-holder-250"></div>
                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->

                <div class="col-md-3">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Progress Stats
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">

                            <div class="progress-stat">

                                <div class="progress-stat-label">
                                    % New Visits
                                </div>

                                <div class="progress-stat-value">
                                    77.7%
                                </div>

                                <div class="progress progress-striped progress-sm active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="77"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 77%">
                                        <span class="sr-only">77.74% Visit Rate</span>
                                    </div>
                                </div> <!-- /.progress -->

                            </div> <!-- /.progress-stat -->

                            <div class="progress-stat">

                                <div class="progress-stat-label">
                                    % Mobile Visitors
                                </div>

                                <div class="progress-stat-value">
                                    33.2%
                                </div>

                                <div class="progress progress-striped progress-sm active">
                                    <div class="progress-bar progress-bar-tertiary" role="progressbar"
                                         aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                                        <span class="sr-only">33% Mobile Visitors</span>
                                    </div>
                                </div> <!-- /.progress -->

                            </div> <!-- /.progress-stat -->

                            <div class="progress-stat">

                                <div class="progress-stat-label">
                                    Bounce Rate
                                </div>

                                <div class="progress-stat-value">
                                    42.7%
                                </div>

                                <div class="progress progress-striped progress-sm active">
                                    <div class="progress-bar progress-bar-secondary" role="progressbar"
                                         aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">
                                        <span class="sr-only">42.7% Bounce Rate</span>
                                    </div>
                                </div> <!-- /.progress -->

                            </div> <!-- /.progress-stat -->

                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->

                <div class="col-md-4">
                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Server Load
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">
                            <div id="auto-chart" class="chart-holder-200"></div>
                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->

            </div> <!-- /.row -->

            <div class="row">

                <div class="col-md-6">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                Product Sales Today
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">

                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-right">Purchases</th>
                                    <th class="text-right">Revenue</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>CSS Hat</td>
                                    <td class="text-right">264</td>
                                    <td class="text-right">$3,129.98</td>
                                </tr>

                                <tr>
                                    <td>Subtle Patterns</td>
                                    <td class="text-right">20</td>
                                    <td class="text-right">$129.98</td>
                                </tr>

                                <tr>
                                    <td>PNG Hat</td>
                                    <td class="text-right">45</td>
                                    <td class="text-right">$9,129.98</td>
                                </tr>

                                <tr>
                                    <td>Academy</td>
                                    <td class="text-right">560</td>
                                    <td class="text-right">$12,249.98</td>
                                </tr>

                                <tr>
                                    <td>Social Kit</td>
                                    <td class="text-right">120</td>
                                    <td class="text-right">$0.00</td>
                                </tr>

                                <tr>
                                    <td>Pizaa</td>
                                    <td class="text-right">340</td>
                                    <td class="text-right">$0.00</td>
                                </tr>

                                <tr>
                                    <td>Kazaam</td>
                                    <td class="text-right">75</td>
                                    <td class="text-right">$897.00</td>
                                </tr>
                                </tbody>
                            </table>

                        </div> <!-- /.portlet-body -->

                    </div> <!-- /.portlet -->

                </div> <!-- /.col -->

                <div class="col-md-6">

                    <div class="portlet portlet-boxed">

                        <div class="portlet-header">
                            <h4 class="portlet-title">
                                <u>Stacked Chart</u>
                            </h4>
                        </div> <!-- /.portlet-header -->

                        <div class="portlet-body">
                            <div id="vertical-chart" class="chart-holder"></div>
                        </div> <!-- /.portlet-body -->

                    </div>   <!-- /.portlet -->

                </div> <!-- /.col -->

            </div> <!-- /.row -->

        </div> <!-- /.container -->

    </div> <!-- .content -->

</div> <!-- /.content-page -->