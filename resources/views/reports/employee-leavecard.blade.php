<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="{{ public_path('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
        <div class="container-fluid" style="display: flex;" >
            <table class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th rowspan="2" colspan="1">
                            Period
                        </th>
                        <th rowspan="2" colspan="1">
                            Particulars
                        </th>
                        <th rowspan="1" colspan="5">
                            Vacation Leave
                        </th>
                        <th rowspan="1" colspan="3" >
                            Sick Leave
                        </th>
                        <th rowspan="2" colspan="1" >
                            Remarks
                        </th>
                    </tr>
                    <tr>
                        <th>EARNED</th>
                        <th>Absence undertime w/ pay</th>
                        <th>Absence undertime w/o pay</th>
                        <th>BALANCE</th>
                        <th>EARNED</th>
                        <th>Absence undertime w/ pay</th>
                        <th>Absence undertime w/o pay</th>
                        <th>BALANCE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $leave_card)
                        <tr>
                            <td>{{ $leave_card->period }}</td>
                            <td>{{ $leave_card->particulars }}</td>
                            <td>{{ $leave_card->vl_earned }}</td>
                            <td>{{ $leave_card->vl_withpay }}</td>
                            <td>{{ $leave_card->vl_withoutpay }}</td>
                            <td>{{ $leave_card->vl_balance }}</td>
                            <td>{{ $leave_card->sl_earned }}</td>
                            <td>{{ $leave_card->vl_withpay }}</td>
                            <td>{{ $leave_card->sl_withoutpay }}</td>
                            <td>{{ $leave_card->sl_balance }}</td>
                            <td>{{ $leave_card->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
