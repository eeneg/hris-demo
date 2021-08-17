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
            <p>{{ $tranche }}</p>
            <table class="table table-striped">
                <thead>
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
                <tbody>
                    @foreach ($salarysched as $key => $salarygrade)
                        <tr v-for="(salarygrade, index) in salarygrades" :key="salarygrade.id" class="text-center amounts">
                            <td style="width: calc(100%-150px);"> {{ $key + 1 }} </td>
                            @foreach ($salarygrade as $data)
                                <td style="width: calc(100%-150px);" v-for="amounts in salarygrade" :key="amounts.id">
                                    {{ $data->amount }} <br>
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
