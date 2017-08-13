<html>
<head>
    <title>{{ config('app.name', 'CapMyRisk.com') }} Subscribed</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,300,700">

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Oswald';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 50px;
        }

        .quote {
            font-size: 30px;
            line-height: 30px;
        }

        .explanation {
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">Email-Adresse bestätigt</div>
        <div class="quote">Vielen Dank für die Bestätigung deiner Email-Adresse {{ $user->email }}.
            Wir informieren dich gern, wenn unsere Seite aktiv ist.
        </div>
    </div>
</div>
</body>
</html>
