@inject('carbon', 'Carbon\Carbon')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

       <style>
            .container-fluid {
                margin-left:auto;
                margin-right:auto;
                width:100%
            }

            .table{
                color:#111827;
                margin-bottom:1rem;
                width:100%;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 0;
            }
            .table td,.table th{
                border-top:1px solid #e5e7eb;
                padding:.75rem;
                vertical-align:top
            }
            .table thead th{
                border-bottom:2px solid #e5e7eb;
                vertical-align:bottom
            }
            .table tbody+tbody{
                border-top:2px solid #e5e7eb
            }
            .table-bordered,.table-bordered td,.table-bordered th{
                border:1px solid #e5e7eb
            }
            .table-bordered thead td,.table-bordered thead th{
                border-bottom-width:2px
            }
            .table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{
                border:0
            }
            .table-striped tbody tr:nth-of-type(odd){
                background-color:rgba(0,0,0,.05)
            }
            .text-center{
                text-align:center!important
            }
       </style>

    </head>
    <body style="background-color: white">
        <div class="container-fluid" style="display: flex;" >
            <div class="row">
                <div class="col-md-12 p-0">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td>
                                    Name: {{ $employee_name}} <br>
                                    Birth Date: {{ $employee->birthdate }} <br>
                                    Civil Status: {{ $employee->civilstatus }} <br>
                                </td>
                                <td>
                                    Position: {{ $position->title }}<br>
                                    Office: {{ $dept->address }}<br>
                                    Salary Grade: {{ $id->salaryauthorized->grade }}<br>
                                </td>
                                <td>
                                    Date Hired: <br>
                                    Retirement Date: {{ Carbon\Carbon::parse($employee->birthdate )->addYears(60)->format('Y-m-d') }} <br>
                                    Status:
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12 p-0">
                    <table class="table table-striped table-bordered text-center p-0">
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
                                    <td style="max-width: 200px;">
                                        @switch($leave_card->period->mode)
                                            @case(4)
                                                {{ Carbon\Carbon::parse($leave_card->period->data)->format('F Y') }}
                                            @break
                                            @case(3)
                                                @php
                                                    $date = collect($leave_card->period->data)
                                                        ->map(fn ($date) => (array) $date)
                                                        ->values()
                                                        ->sort()
                                                        ->map(fn ($date) => ['month'=> $carbon->parse($date['date'])->setTimeZone('Asia/Manila')->format('Y-m'), 'date' => $carbon->parse($date['date'])->setTimeZone('Asia/Manila')->format('d')])
                                                        ->groupBy('month')
                                                        ->map(function ($entry) use ($carbon) {
                                                            return $carbon->parse($entry[0]['month'])->format('M') . ' ' . collect($entry)->map(fn ($e) => $e['date'])->join(', ') . ' ' .$carbon->parse($entry[0]['month'])->format('Y');
                                                        });
                                                @endphp
                                                {{ collect($date)->join(' — ') }}
                                                @break
                                            @case(2)
                                                {{
                                                    Carbon\Carbon::parse($leave_card->period->data->start)->format('F d, Y')
                                                    . ' to ' .
                                                    Carbon\Carbon::parse($leave_card->period->data->end)->format('F d, Y')
                                                }}
                                                @break
                                            @default
                                                {{ Carbon\Carbon::parse($leave_card->period->data)->format('F d, Y') }}
                                        @endswitch
                                    </td>
                                    <td>{{
                                            $leave_card?->particulars?->leave_type .
                                            ($leave_card?->particulars?->leave_type == 'Tardy' ||
                                            $leave_card?->particulars?->leave_type == 'Undertime'
                                            ? $leave_card?->particulars?->count . 'x' : "") . ' ' .
                                            ($leave_card?->particulars?->days ? $leave_card?->particulars?->days : 0)  . '-' .
                                            ($leave_card?->particulars?->hours ? $leave_card?->particulars?->hours : 0) . '-' .
                                            ($leave_card?->particulars?->mins ? $leave_card?->particulars?->mins : 0)
                                        }}
                                    </td>
                                    <td>{{ $leave_card->vl_earned }}</td>
                                    <td>{{ $leave_card->vl_withpay }}</td>
                                    <td>{{ $leave_card->vl_withoutpay }}</td>
                                    <td>{{ $leave_card->vl_balance }}</td>
                                    <td>{{ $leave_card->sl_earned }}</td>
                                    <td>{{ $leave_card->sl_withpay }}</td>
                                    <td>{{ $leave_card->sl_withoutpay }}</td>
                                    <td>{{ $leave_card->sl_balance }}</td>
                                    <td>{{ $leave_card->remarks }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
