<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>
            html {
                font-family: sans-serif;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
                margin: 0
            }
            .divmain{

            }
            .tablemain{
                padding: 0;
                margin: 0;
                border-spacing: 0;
            }
            .divtable{
                margin: 20 0 0 0;

            }
            .trow{
                width: 100%;

            }
            .tthead{
                width: 560px ;
                border: solid black 2px;
            }
            .tthead2{
                width: 260px;
                border: solid 2px;
                font-size: 1.3rem;
            }
            .tdata{
                width: 560px ;
                height: 50px;
                border: solid black 2px;
                font-size: 1.1rem;
                font-weight: bold;
            }
            .tdata2{
                width: 260px;
                border: solid black 2px;
                text-align: right;
                font-size: 1.3rem;
                padding: 0 10px 0 0;
            }
            .tdata3{
                text-align: right;
                height: 50px;
                font-weight: bold;
                border: solid black 2px;
                font-weight: bold;
                font-size: 1.3rem;
                padding: 0 10px 0 0;
            }
        </style>
    </head>
    <body style="width: 100%">
        <main role="main" style="width: 100% " >
            <div class="divmain" style="width: 100%">
                <div class="header" style="text-align: center">
                    <h1 style="font-weight: bold;margin:0">SUMMARY BY OFFICE</h1>
                    <p style="font-size: 1.6rem;margin:0">{{ $current_year }}</p>
                </div>
                <div class="divtable">
                    <table class="tablemain">
                        <thead>
                            <tr class="trow">
                                <th class="tthead" style="border-right: none; border-top: none; border-left: none;"></th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">{{ $previous_year }} Authorized</th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">{{ $current_year }} Proposed</th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">inc/dec</th>
                            </tr>

                            @foreach ($plantilla_depts as $dept)
                            <tr>
                                <td class="tdata" style="border-right: none; border-top: none;"> {!! strtoupper($dept->department->description) !!} </td>
                                <td class="tdata2" style="border-right: none; border-top: none;"> {{ $dept->amount->auth_total }} </td>
                                <td class="tdata2" style="border-right: none; border-top: none;"> {{ $dept->amount->prop_total }} </td>
                                <td class="tdata2" style="border-top: none;"> {{ $dept->amount->inc_dec }} </td>
                            </tr>
                            @endforeach
                            
                            <tr>
                                <td class="tdata3" style="border-right: none; border-top: none;"> GRAND TOTAL ----- </td>
                                <td class="tdata3" style="border-right: none; border-top: none;"> {{ $auth_grand_total }} </td>
                                <td class="tdata3" style="border-right: none; border-top: none;"> {{ $prop_grand_total }} </td>
                                <td class="tdata3" style="border-top: none;"> {{ $inc_dec_grand_total }} </td>
                            </tr>

                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <script type="text/php">

        </script>
    </body>
</html>
