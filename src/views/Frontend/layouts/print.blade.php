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
            }
            table tr td{
                vertical-align: top;
                padding: 10px 0;
            }
            table,
            table tr td,
            table tr td p,
            table tr td div{
                page-break-inside:avoid;
            }
            table tr td h2,
            table tr td div h2
            {
                font-size: 15px !important;
            }
            table tr td,
            table tr td p,
            table tr td div,
            table tr td a
            {
                font-size: 12px !important;
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