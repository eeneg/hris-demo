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
                height: 13in;
                width: 8.5in;
                font-family: Arial, Helvetica, sans-serif;
                margin: 0
            }
            .divmain{

            }
            .tablemain{
                width: 100%;
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
                font-size: 1.3rem;
            }
            .tthead2{
                width: 260px;
                border: solid 2px;
                font-size: 1.3rem;
            }
            .tdata{
                width: 360px ;
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
            .theadTitle{
                width: 100%;
            }
        </style>
    </head>
    <body style="width: 100%">
        <main role="main" style="width: 100% " >
            <div class="divmain" style="width: 100%">
                <div class="divtable">
                    <table class="tablemain" style="margin-bottom: 200px;">
                        <thead class="theadTitle">
                            <th colspan="4">
                                <div class="header" style="text-align: center">
                                    <h1 style="font-weight: bold;margin:0">FOREIGN TRAVEL</h1>
                                    <p style="font-size: 1.6rem;font-weight: normal;margin:0 0 20px 0">{{ $d['current_month'] }} {{ $d['current_year'] }}</p>
                                </div>
                            </th>

                        </thead>
                        <thead>
                            <tr class="trow">
                                <th class="tthead" style="border-right: none; border-top: none; border-left: none;">Employee</th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">Type of Leave</th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">Days</th>
                                <th class="tthead2" style="border-right: none; border-top: none; border-left: none;">Inclusive Dates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($d['data'] as $values)
                            <tr>
                                <td class="tdata" style="border-right: none; border-top: none;">{{ $values['name'] }}</td>
                                <td class="tdata2" style="border-right: none; border-top: none;">{{ $values['leave_type'] }}</td>
                                <td class="tdata2" style="border-right: none; border-top: none;">{{ $values['days'] }}</td>
                                <td class="tdata2" style="border-top: none;">{{ $values['inclusive_dates'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="height: 40px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1">
                                    Prepared by:
                                </td>
                                <td>

                                </td>
                                <td colspan="2">
                                    Noted by:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="height: 40px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                    <p style="margin-bottom: 0;">{{ @$d['prepared_by'][0]['name'] }}</p>
                                </td>
                                <td></td>
                                <td colspan="2" style="text-align: center; margin-bottom: 0;">
                                    <p>{{ @$d['noted_by']['name'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                   {{ @$d['prepared_by'][0]['position'] }}
                                </td>
                                <td></td>
                                <td colspan="2" style="text-align: center;">
                                    {{ @$d['noted_by']['position'] }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="height: 40px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                    <p style="margin-bottom: 0;">{{ @$d['prepared_by'][1]['name'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                    {{ @$d['prepared_by'][1]['position'] }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" style="height: 40px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                    <p style="margin-bottom: 0;">{{ @$d['prepared_by'][2]['name'] }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="text-align: center;">
                                    {{ @$d['prepared_by'][2]['position'] }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </main>
        <script type="text/php">

        </script>
    </body>
</html>


