<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- Responsive Meta Tag -->

        <link rel="stylesheet" href="{{ asset('newsletter/css/frontend/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('newsletter/css/frontend/newsletter.css') }}">

        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
                text-align: justify;
            }
            @page { margin: 30px 50px; background: #fff; font-family: Arial, Helvetica, sans-serif;}

            .bloc{
                border-bottom:1px solid #ddd;
                padding: 10px 0 20px 0;
                margin-bottom: 10px;
                page-break-inside:avoid;
            }

            .col-md-9{
                width: 65%;
                display: inline-block;
            }
            .col-md-3{
                display: inline-block;
                width: 25%;
            }
            .clear{
                content: '.';
                clear: both;
                height:1px;
                visibility: hidden;
            }
            div p a{
                display: none;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <!-- Main content -->
            @yield('content')
            <!-- Fin contenu -->
        </div>
    </body>
</html>