<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Title -->
    <title>Coming soon | Unify - Responsive Website Template</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../../favicon.ico">

    <!-- Google Fonts -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600" rel="stylesheet" type="text/css">

    <!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/bootstrap.min.css">

    <!-- CSS Unify -->
    <link rel="stylesheet" href="../../assets/css/unify.css">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="../../assets/css/custom.css">
</head>

<body>
<main class="g-min-height-100vh g-flex-centered g-bg-size-cover g-bg-cover g-bg-bluegray-opacity-0_3--after g-pa-15" style="background-image: url(assets/img-temp/1920x1080/img1.jpg);">
    <div class="text-center g-max-width-700 g-flex-centered-item g-z-index-1 g-color-white">
        <h1 class="display-3 g-mb-30">Coming Soon</h1>
        <p class="g-font-size-22 g-mb-50">Dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias</p>

        <div class="js-countdown row g-z-index-1"
             data-end-date="2017/09/09"
             data-month-format="%m"
             data-days-format="%D"
             data-hours-format="%H"
             data-minutes-format="%M"
             data-seconds-format="%S">
            <div class="col-3 g-py-10">
                <strong class="js-cd-days d-block display-4 mx-auto g-width-70 g-height-70 g-bg-white-opacity-0_2 g-font-weight-700 g-font-size-25 g-rounded-50x g-line-height-1 g-pa-20 mb-2"></strong>
                <em class="g-font-style-normal g-font-size-20">Days</em>
            </div>

            <div class="col-3 g-brd-left g-brd-white-dark-v3 g-py-10">
                <strong class="js-cd-hours d-block display-4 mx-auto g-width-70 g-height-70 g-bg-white-opacity-0_2 g-font-weight-700 g-font-size-25 g-rounded-50x g-line-height-1 g-pa-20 mb-2"></strong>
                <em class="g-font-style-normal g-font-size-20">Hours</em>
            </div>

            <div class="col-3 g-brd-left g-brd-white-dark-v3 g-py-10">
                <strong class="js-cd-minutes d-block display-4 mx-auto g-width-70 g-height-70 g-bg-white-opacity-0_2 g-font-weight-700 g-font-size-25 g-rounded-50x g-line-height-1 g-pa-20 m2-3"></strong>
                <em class="g-font-style-normal g-font-size-20">Minutes</em>
            </div>

            <div class="col-3 g-brd-left g-brd-white-dark-v3 g-py-10">
                <strong class="js-cd-seconds d-block display-4 mx-auto g-width-70 g-height-70 g-bg-white-opacity-0_2 g-font-weight-700 g-font-size-25 g-rounded-50x g-line-height-1 g-pa-20 m2-3"></strong>
                <em class="g-font-style-normal g-font-size-20">Seconds</em>
            </div>
        </div>
    </div>
</main>

<!-- JS Global Compulsory -->
<script src="../../assets/vendor/jquery/jquery.min.js"></script>
<script src="../../assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
<script src="../../assets/vendor/tether.min.js"></script>
<script src="../../assets/vendor/bootstrap/bootstrap.min.js"></script>

<!-- JS Implementing Plugins -->
<script src="../../assets/vendor/appear.js"></script>
<script src="../../assets/vendor/jquery.countdown.min.js"></script>

<!-- JS Unify -->
<script src="../../assets/js/hs.core.js"></script>
<script src="../../assets/js/components/hs.countdown.js"></script>

<!-- JS Customization -->
<script src="../../assets/js/custom.js"></script>

<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        // initialization of countdowns
        var countdowns = $.HSCore.components.HSCountdown.init('.js-countdown', {
            yearsElSelector: '.js-cd-years',
            monthElSelector: '.js-cd-month',
            daysElSelector: '.js-cd-days',
            hoursElSelector: '.js-cd-hours',
            minutesElSelector: '.js-cd-minutes',
            secondsElSelector: '.js-cd-seconds'
        });
    });
</script>
</body>
</html>
