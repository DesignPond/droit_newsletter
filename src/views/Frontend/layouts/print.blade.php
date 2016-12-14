<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- Define Charset -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <!-- Responsive Meta Tag -->

        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
                text-align: justify;
                box-sizing:border-box;
            }
            @page {
                padding: 30px; margin: 30px 50px; background: #fff; font-family: Arial, Helvetica, sans-serif;
            }
            .bloc{
                margin: 10px 0;
                width: 100%;
            }
            .bloc,
            .bloc div,
            .bloc div p,
            .bloc div p a,
            .bloc p
            .bloc a,
            .bloc ul li
            {
                font-size: 14px !important;
                line-height: 18px;
                box-sizing:border-box;
            }
            .arret, .analyse{
                width: 100%;
                display: block;
            }
            .arret-content{
                display: inline-block;
                box-sizing:border-box;
                width: 70%;
            }
            .arret-categories{
                display: inline-block;
                width:29%;
                box-sizing:border-box;
                text-align: center;
            }
            .arret-categories a{
                display: block;
                width:100%;
                text-align: center;
                margin-bottom: 3px;
            }

            hr{
                display: block;
                clear: both;
                height: 1px;
                margin: 5px 0;
                visibility: hidden;
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