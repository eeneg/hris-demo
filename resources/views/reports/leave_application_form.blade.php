<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>
            .container {
                width: 90%;
                margin: 0 auto;
                padding: 0;
                border: 1px solid #000;
            }
            .name-container {
                border-top: 1px solid #000;
                border-bottom: 1px solid #000;
                padding: 10px 0;
                display: grid;
                grid-template-columns: auto auto auto;
                width: 100%
            }
            .ordinary-text {
                font-size: 10px;
            }
            .leave-type {
                display: flex;
                margin-top: 3px;
                margin-left: 1%;
                align-items : center;
            }
            .box {
                margin-left: 1%;
                width: 11px;
                height: 11px;
                padding: 0;
            }
            table, th, td {
                border: 1px solid;
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        {{-- {{$leave}} --}}
        <main role="main" style="width: 100% " >
            <div class="container" style="width: 100%">
                <div class="ordinary-text" style="font-size: 10px;">
                    <div>
                        Civil Service Form No. 6
                    </div>
                    <div>
                        Revised 2020
                    </div>
                </div>
                <div class="ordinary-text" style="text-align: center;">
                    <div style="position: absolute; left: 100px; top: 20px;">
                        <img style="height: 100px;" src="{{ asset('/storage/project_files/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                    </div>
                    <div>
                        Republic of the Philippines
                    </div>
                    <div style="font-weight: bold;">
                        Province of Davao del Sur
                    </div>
                    <div>
                        Matti, Digos City
                    </div>
                </div>
                <div style="text-align: center; font-size: 13px;">
                    <h1>Application For Leave</h1>
                </div>
                <div class=""
                    style=
                    "
                        display: grid;
                        grid-template-columns: 30% 70%;
                        width: 100%;
                        padding: 10px 0;
                        border-top: 1px solid #000;
                        font-size: 10px;
                    "
                >
                    <div>
                        <div>
                            1. OFFICE/DEPARTMENT
                        </div>
                        <div style="padding: 3px;">
                            {{ $leave->department }}
                        </div>
                    </div>
                    <div style="display: block">
                        <div style="display: grid; grid-template-columns: 50px auto auto auto; text-align: center;">
                            <div>
                                2. NAME:
                            </div>
                            <div>
                                <div>
                                    (LAST)
                                </div>
                                <div style="margin-top: 5px;">
                                    {{ $employee->surname }}
                                </div>
                            </div>
                            <div>
                                <div>
                                    (FIRST)
                                </div>
                                <div style="margin-top: 5px;">
                                    {{ $employee->firstname }}
                                </div>
                            </div>
                            <div>
                                <div>
                                    (MIDDLE)
                                </div>
                                <div style="margin-top: 5px;">
                                    {{ $employee->middlename }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="" style="height:15px;">

                </div>
                <div class="" style="font-size: 10px; display: grid; grid-template-columns: 30% 40% 30%; width: 100%; padding: 10px 0; border-top: 1px solid #000;border-bottom: 1px solid #000;">
                    <div style="display: flex; width: 100%;">
                        <div style="">
                            3. DATE OF FILING
                        </div>
                        <div style="width: 30%; margin-left: 5px; border-bottom: 1px solid;">
                            {{$leave->date_of_filing}}
                        </div>
                    </div>
                    <div style="display: flex; width: 100%;">
                        <div>
                            4. POSITION
                        </div>
                        <div style="margin-left: 5px; border-bottom: 1px solid;">
                            {{ $leave->position }}
                        </div>
                    </div>
                    <div style="display: flex; width: 100%;">
                        <div>
                            5. SALARY
                        </div>
                        <div style="width: 30%; margin-left: 5px; border-bottom: 1px solid;">
                            {{ $leave->salary }}
                        </div>
                    </div>
                </div>
                <div style="border:1px solid; font-weight:bold; text-align:center; font-size: 15px;">
                    6. DETAILS OF APPLICATION
                </div>
                <div style="display: grid; grid-template-columns: 55% 45%;">
                    <div style="font-size: 10px; border: 1px solid;">
                        <div class="leave-type">
                            6.A  TYPE OF LEAVE TO BE AVAILED OF
                        </div>
                        <div class="leave-type">
                            <input class="box" type="checkbox" {{ $leave->leavetype->abbreviation == 'VL' ? 'checked' : '' }}>
                            Vacation Leave (Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'FL' ? 'checked' : '' }}>
                            Mandatory/Forced Leave(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'SL' ? 'checked' : '' }}>
                            Sick Leave  (Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'MatL' ? 'checked' : '' }}>
                            Maternity Leave (R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'PL' ? 'checked' : '' }}>
                            Paternity Leave (R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'SPL' ? 'checked' : '' }}>
                            Special Privilege Leave (Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'SOLO' ? 'checked' : '' }}>
                            Solo Parent Leave (RA No. 8972 / CSC MC No. 8, s. 2004)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'StudL' ? 'checked' : '' }}>
                            Study Leave (Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'VAWC' ? 'checked' : '' }}>
                            10-Day VAWC Leave (RA No. 9262 / CSC MC No. 15, s. 2005)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'REHAB' ? 'checked' : '' }}>
                            Rehabilitation Privilege (Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'SLBW' ? 'checked' : '' }}>
                            Special Leave Benefits for Women (RA No. 9710 / CSC MC No. 25, s. 2010)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box">
                            Special Emergency (Calamity) Leave (CSC MC No. 2, s. 2012, as amended)
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->leavetype->abbreviation == 'AD' ? 'checked' : '' }}>
                            Adoption Leave (R.A. No. 8552)
                        </div>
                        <div style="margin-top: 2%; margin-left: 3%;">
                            Others:
                        </div>
                        <div style="border-bottom: 1px solid #000; margin-top: 2%; margin-left: 3%; width: 25%; margin-bottom: 10px;">
                        </div>
                    </div>
                    <div style="border: 1px solid">
                        <div style="font-size: 7px;">
                            <div class="leave-type">
                                6.B  DETAILS OF LEAVE
                            </div>
                            <div class="leave-type">
                                In case of Vacation/Special Privilege Leave:
                            </div>
                            <div class="leave-type" style="padding: 0 5px 0 5px;">
                                <div style="width:28%;">
                                    <input type="checkbox" class="box" {{ $leave->spent == 'within_the_philippines' ? 'checked' : '' }}>
                                    Within the Philippines
                                </div>
                                <div style="width: 70%; border-bottom: 1px solid; height: 12px; text-align:center;">
                                    @if ($leave->spent == 'within_the_philippines')
                                        {{ $leave->spent_specified }}
                                    @endif
                                </div>
                            </div>
                            <div class="leave-type" style="display:flex; padding: 0 5px 0 5px">
                               <div style="width: 28%;">
                                    <input type="checkbox" class="box" {{ $leave->spent == 'abroad' ? 'checked' : '' }}>
                                    Abroad (Specify)
                               </div>
                                <div style="width: 70%; border-bottom: 1px solid; height: 12px; text-align:center;">
                                   @if ($leave->spent == 'abroad')
                                       {{ $leave->spent_specified }}
                                   @endif
                                </div>
                            </div>
                            <div class="leave-type">
                                In case of Sick Leave:
                            </div>
                            <div class="leave-type" style="display:flex; padding: 0 5px 0 5px">
                                <div style="width: 34%;">
                                     <input type="checkbox" class="box" {{ $leave->spent == 'in_hospital' ? 'checked' : '' }}>
                                     In Hospital (Specify Illness)
                                </div>
                                 <div style="width: 64%; border-bottom: 1px solid; height: 14px; text-align:center;">
                                     @if ($leave->spent == 'in_hospital')
                                         {{ $leave->spent_spec }}
                                     @endif
                                 </div>
                            </div>
                            <div class="leave-type" style="display:flex; padding: 0 5px 0 5px">
                                <div style="width: 34%;">
                                     <input type="checkbox" class="box" {{ $leave->spent == 'out_patient' ? 'checked' : '' }}>
                                     Out Patient (Specify Illness)
                                </div>
                                 <div style="width: 64%; border-bottom: 1px solid; height: 15px; text-align:center;">
                                     @if ($leave->spent == 'out_patient')
                                         {{ $leave->spent_spec }}
                                     @endif
                                 </div>
                            </div>
                            <div style="border-bottom: 1px solid; width: 96%; margin-left: 1%; height: 12px;">

                            </div>
                            <div class="leave-type">
                                In case of Special Leave Benefits for Women:
                            </div>
                            <div class="leave-type">
                                In case of Study Leave:
                            </div>
                            <div class="leave-type">
                                <input type="checkbox" class="box" {{ $leave->spent == 'completion_of_masters_degree' ? 'checked' : '' }}>
                                Completion of Master's Degree
                            </div>
                            <div class="leave-type">
                                <input type="checkbox" class="box" {{ $leave->spent == 'board_examination_review' ? 'checked' : '' }}>
                                BAR/Board Examination Review
                            </div>
                            <div class="leave-type">
                                Other purpose:
                            </div>
                            <div class="leave-type">
                                <input type="checkbox" class="box" {{ $leave->spent == 'monetiztion' ? 'checked' : '' }}>
                                Monetization of Leave Credits
                            </div>
                            <div class="leave-type">
                                <input type="checkbox" class="box" {{ $leave->spent == 'terminal_leave' ? 'checked' : '' }}>
                                Terminal Leave
                            </div>
                        </div>
                    </div>
                    <div class="ordinary-text" style="border-right: 1px solid; padding: 10px;">
                        <div style="width: 100%;">
                            6.C NUMBER OF WORKING DAYS APPLIED FOR
                        </div>
                        <div style="border-bottom: 1px solid; width: 60%; height: 15px; margin-bottom: 10px; text-align:center">
                            {{ $leave->working_days }}
                        </div>
                        <div style="margin-left: 2%">
                            INCLUSIVE DATES
                        </div>
                        <div style="border-bottom: 1px solid; width: 60%; min-height: 15px; margin-bottom: 10px; text-align:center">
                            @switch($leave->inclusive_dates->mode)
                                @case(3)
                                    @php
                                        $date = collect($leave->inclusive_dates->data)
                                                ->values()
                                                ->sort()
                                                ->map(fn ($date) => ['month'=> Carbon\Carbon::parse($date->date)->setTimeZone('Asia/Manila')->format('Y-m'), 'date' => Carbon\Carbon::parse($date->date)->setTimeZone('Asia/Manila')->format('d')])
                                                ->groupBy('month')
                                                ->map(function ($entry) {
                                                    return Carbon\Carbon::parse($entry[0]['month'])->format('M') . ' ' . collect($entry)->map(fn ($e) => $e['date'])->join(', ') . ' ' . Carbon\Carbon::parse($entry[0]['month'])->format('Y');
                                            })->join(' - ');
                                    @endphp
                                        {{ collect($date)->join(' , ') }}
                                    @break
                                @case(2)
                                    {{
                                        Carbon\Carbon::parse($leave->inclusive_dates->data->start)->format('F d, Y')
                                        . ' to ' .
                                        Carbon\Carbon::parse($leave->inclusive_dates->data->end)->format('F d, Y')
                                    }}
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div class="ordinary-text" style="padding: 10px;">
                        <div style="">
                            6.D COMMUTATION
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->commutation == 'requested' ? 'checked' : '' }}>
                            Not Requested
                        </div>
                        <div class="leave-type">
                            <input type="checkbox" class="box" {{ $leave->commutation == 'not_requested' ? 'checked' : '' }}>
                            Requested
                        </div>
                    </div>
                </div>
                <div style="border:1px solid; font-weight:bold; text-align:center; font-size: 15px;">
                    7. DETAILS OF ACTION ON APPLICATION
                </div>
                <div class="" style="font-size: 10px; display: grid; grid-template-columns: 55% 45%;">
                    <div style="border-right: 1px solid; padding: 10px;">
                        <div>
                            7.A  CERTIFICATION OF LEAVE CREDITS
                        </div>
                        <div style="width: 100%; text-align: center; margin-top: 8px;">
                            As of <span style="text-decoration: underline;">{{ $leave->credit_as_of }}</span>
                        </div>
                        <div style="text-align: center; margin-top: 5px;">
                            <table style="margin: auto; width: 80%;">
                                <tr>
                                    <th></th>
                                    <th>Vacation Leave</th>
                                    <th>Sick Leave</th>
                                </tr>
                               <tbody>
                                    <tr>
                                        <td>
                                            Total Earned
                                        </td>
                                        <td>{{ $leave->vacation_balance }}</td>
                                        <td>{{ $leave->sick_balance }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Less this application
                                        </td>
                                        <td>{{ $leave->vacation_less }}</td>
                                        <td>{{ $leave->sick_less }}</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Balance
                                        </td>
                                        <td>{{ $leave->vacation_balance == null ? 0 : $leave->vacation_balance - $leave->vacation_less }}</td>
                                        <td>{{ $leave->sick_balance == null ? 0 : $leave->sick_balance - $leave->sick_less }}</td>
                                    </tr>
                               </tbody>
                            </table>
                        </div>
                        <div style="align-content: center; text-align: center; margin-top: 30px;">
                            <div style="border-bottom: 1px solid; margin: auto; width: 50%; font-size: 13px;">
                                {{ @$leave->credit_officer->name }}
                            </div>
                            <div>
                                (Authorized Officer)
                            </div>
                        </div>
                    </div>
                    <div style="border-right: 1px solid; padding: 10px; font-size: 10px;">
                        <div>
                            7.B  RECOMMENDATION
                        </div>
                        <div class="leave-type" style="font-size: 10px;">
                            <input type="checkbox" class="box" {{ $leave->recommendation_approved == '1' ? 'checked' : '' }}>
                            For Approval
                        </div>
                        <div class="" style="font-size: 10px;margin-top: 3px;">
                            @php
                            function splitTextRecommendation($text, $firstMaxLength = 50, $otherMaxLength = 80, $maxParts = 3) {
                                $result = [];

                                // First part with a shorter max length
                                $cutPosition = strrpos(substr($text, 0, $firstMaxLength), ' ');
                                if ($cutPosition === false) {
                                    $cutPosition = $firstMaxLength; // Hard cut if no space is found
                                }
                                $result[] = trim(substr($text, 0, $cutPosition));
                                $text = trim(substr($text, $cutPosition));

                                // Remaining parts with a longer max length
                                while (strlen($text) > $otherMaxLength && count($result) < $maxParts + 1) {
                                    $cutPosition = strrpos(substr($text, 0, $otherMaxLength), ' ');
                                    if ($cutPosition === false) {
                                        $cutPosition = $otherMaxLength; // Hard cut if no space is found
                                    }

                                    $result[] = trim(substr($text, 0, $cutPosition));
                                    $text = trim(substr($text, $cutPosition));
                                }

                                // Add any remaining text as the last part
                                if (!empty($text)) {
                                    $result[] = $text;
                                }

                                // Ensure we have enough containers
                                while (count($result) < $maxParts + 1) {
                                    $result[] = '';
                                }

                                return $result;
                            }

                            // Example text from a database or input
                            $splitTexts = splitTextRecommendation($leave->recommendation_disapproved_due_to ?? '', 40, 65, 3);
                        @endphp

                        <div class="leave-type" style="display: flex;">
                            <div style="width: 41%;">
                                <input type="checkbox" class="box" {{ $leave->recommendation_approved == '0' ? 'checked' : '' }}>
                                For disapproval due to
                            </div>
                            <div style="border-bottom: 1px solid; width: 53%; margin-top: 8px;">
                                {{ $splitTexts[0] }}
                            </div>
                        </div>

                        @foreach(array_slice($splitTexts, 1) as $part)
                            <div style="border-bottom: 1px solid; margin: 10px auto 0px; width: 89%;">
                                {{ $part }}
                            </div>
                        @endforeach

                            <div style="align-content: center; text-align: center; margin-top: 30px;">
                                <div style="border-bottom: 1px solid; margin: auto; width: 65%; font-size: 13px;">
                                    {{ @$leave->recommendation_officer->name }}
                                </div>
                                <div>
                                    (Authorized Officer)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ordinary-text" style="display: grid; grid-template-columns: 55% 45%; border-top: 1px solid #000;">
                    <div style="border-right: 1px solid; padding: 10px;">
                        <div>
                            7.C  APPROVED FOR:
                        </div>
                        <div style="margin-left: 2%">
                            <div style="display:flex; width: 100%;">
                                <div style="width: 9%; max_width: 9%;text-align: center;border-bottom: 1px solid;">
                                    {{ $leave->days_with_pay }}
                                </div>
                                <div>
                                    days with pay
                                </div>
                            </div>
                            <div style="display:flex; width: 100%;">
                                <div style="width: 9%; max_width: 9%;text-align: center;border-bottom: 1px solid;">
                                    {{ $leave->days_without_pay }}
                                </div>
                                <div>
                                    days without pay
                                </div>
                            </div>
                            <div style="display:flex; width: 100%;">
                                <div style="width: 9%; max_width: 9%;text-align: center;border-bottom: 1px solid;">
                                    {{ $leave->others }}
                                </div>
                                <div>
                                    others (specify)
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 30px; text-align: center;">
                            <div style="margin: auto; width: 50%; min-width: 35%; border-bottom: 1px solid;">
                                <span style="font-size: 13px;">
                                    {{-- {{ @$leave->noted_by_officer->name }} --}}
                                    RAUL D. RAUT, EnP, JD
                                </span>
                            </div>
                            <div>
                                PGDH - Human Resource Management Officer
                            </div>
                        </div>
                    </div>
                    <div style="border-right: 1px solid; padding: 10px;">
                        <div>
                            7.D   DISAPPROVED DUE TO:
                        </div>
                        @php
                            function splitText($text, $maxLines) {
                                $words = explode(' ', $text);
                                $totalWords = count($words);
                                $splitTextArray = [];

                                // If the text is short, just return it in the first div, leaving the rest empty
                                if ($totalWords <= ($maxLines * 2)) { // Assuming ~5 words per line
                                    $splitTextArray[] = $text;
                                } else {
                                    $chunkSize = ceil($totalWords / $maxLines);
                                    $splitTextArray = array_chunk($words, $chunkSize);
                                    $splitTextArray = array_map(fn($chunk) => implode(' ', $chunk), $splitTextArray);
                                }

                                // Ensure exactly three divs
                                while (count($splitTextArray) < $maxLines) {
                                    $splitTextArray[] = ""; // Add empty placeholders
                                }

                                return $splitTextArray;
                            }

                            $text = $leave->gov_disapproved_due_to ?? '';
                            $splitTextArray = splitText($text, 3);
                        @endphp

                        <div style="margin-left: 2%">
                            @foreach ($splitTextArray as $textChunk)
                                <div style="border-bottom: 1px solid; margin-top: 10px;">
                                    {{ $textChunk }}
                                </div>
                            @endforeach
                        </div>
                        <div style="margin-top: 28px; text-align: center;">
                            <div style="margin: auto; width: 50%; min-width: 35%; border-bottom: 1px solid;">
                                <span style="font-size: 13px;">
                                    {{-- {{ @$leave->governor_approved != 1 || $leave->governor_approved != 0 ? $leave->governor_approval_officer->name : '' }} --}}
                                    YVONNE R. CAGAS
                                </span>
                            </div>
                            <div>
                                Provincial Governor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>

        </script>
    </body>
</html>


