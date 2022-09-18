<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        {{-- <link href="{{ public_path('css/app.css') }}" rel="stylesheet"> --}}
        <style>
            html {
                width: 8.5in;
                height: 13in;
            }
            table{
                border-collapse: collapse;
            }

            .text-center {
                text-align: center !important;
            }
            .amounts {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 77%;
            }

            table td{
                margin: 0px 20px !important;
                border: 1px;
            }
        </style>

    </head>
    <body>
        <div class="container-fluid center" style="margin: -40px 0 -20px 0;">
            <div style="padding: 0;margin: 0;text-align: center;">
                <h2><strong>{{ $tranche }}</strong></h2>
            </div>
            <table class="table table-striped table-bordered">
                <thead >
                    <tr class="text-center">
                        <td style="width: calc(100%-150px); font-weight:bold">Grade</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  1</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  2</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  3</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  4</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  5</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  6</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  7</td>
                        <td style="width: calc(100%-150px); font-weight:bold" v-for="n in 8" :key="n.id">Step  8</td>
                    </tr>
                </thead>
                <tbody >
                    @foreach ($salarysched as $key => $salarygrade)
                        <tr v-for="(salarygrade, index) in salarygrades" :key="salarygrade.id" class="text-center amounts"  style="border-top: solid 1px;" >
                            <td style="width: calc(100%-150px);font-weight: bold;line-height: 1px;"><h3>{{ $key + 1 }}</h3></td>
                            @foreach ($salarygrade as $data)
                                <td style="width: 80px;" v-for="amounts in salarygrade" :key="amounts.id">
                                    <strong>{{ number_format($data->amount, 0) }}</strong><br>
                                    ({{  number_format($data->annual, 0) }})
                                </td>
                            @endforeach
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </body>
</html>
