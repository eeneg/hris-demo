<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {{-- <link href="{{ public_path('css/app.css') }}" rel="stylesheet"> --}}
        <style>
            .text-center {
                text-align: center !important;
            }
            .amounts {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 80%;
            }
            .center {
                margin-left: 20px !important;
            }

            table td{
                margin: 0px 20px !important;
            }
        </style>

    </head>
    <body>
        <div class="container-fluid center" style="" >
            <h1>NOSA</h1>
        </div>
    </body>
</html>
