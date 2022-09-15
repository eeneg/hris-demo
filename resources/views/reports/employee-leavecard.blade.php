@inject('carbon', 'Carbon\Carbon')
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
                            {{$leave_card}}
                            <td>
                                @switch($leave_card->period->mode)
                                    @case(3)
                                        @php
                                            $date = collect($leave_card->period->data)
                                                ->map(fn ($date) => (array) $date)
                                                ->values()
                                                ->sort()
                                                ->map(fn ($date) => ['month'=> $carbon->parse($date['date'])->setTimeZone('Asia/Manila')->format('Y-m'), 'date' => $carbon->parse($date['date'])->setTimeZone('Asia/Manila')->format('d')])
                                                ->groupBy('month')
                                                ->map(function ($entry) use ($carbon) {
                                                    return $carbon->parse($entry[0]['month'])->format('M') . ' ' . collect($entry)->map(fn ($e) => $e['date'])->join(',') . ' ' .$carbon->parse($entry[0]['month'])->format('Y');
                                                });
                                        @endphp
                                        {{ collect($date)->join(' — ') }}
                                        @break
                                    @case(2)
                                        {{
                                            Carbon\Carbon::parse($leave_card->start)->format('F d, Y')
                                            . ' to ' .
                                            Carbon\Carbon::parse($leave_card->end)->format('F d, Y')
                                        }}
                                        @break
                                    @default
                                        {{ Carbon\Carbon::parse($leave_card->data)->format('F d, Y') }}
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
