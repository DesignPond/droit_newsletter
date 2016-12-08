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
            @page { margin: 30px; background: #fff; font-family: Arial, Helvetica, sans-serif;}

            table{
                margin-bottom: 5px;
                page-break-inside:avoid;
            }
            table tr td{
                vertical-align: top;
                padding: 10px 0;
            }

            td a.thumb{
                display: block;
                width: 100%;
                margin-bottom: 20px;
                text-align: center;
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