<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

    </style>
</head>
<body>
    @php
        function format($date){
            if(strtotime($date) !== false)
            {
                return Carbon\Carbon::parse($date)->format('F d, Y');
            }
            return $date;
        }

        function format_date($date){
            if(str_contains($date, 'to') || $date == "" || strtotime($date) == false){
                return $date;
            }else if(str_contains($date, '/')){
                return Carbon\Carbon::parse($date)->format("m-d-y");
            }else if(str_contains($date, 'O')){
                $date = str_replace('O', '0', $date);
                return Carbon\Carbon::createFromFormat("m-d-y", $date)->format("m-d-y");
            }else{
                return Carbon\Carbon::createFromFormat("m-d-y", $date)->format("m-d-y");
            }
        }

        function formatbirthDate($date){
            if(strtotime($date) !== false)
            {
                return Carbon\Carbon::parse($date)->format('F d, Y');
            }
            return $date;
        }

        function spacer($avg){
            // return $avg;
            switch ($avg) {
                case $avg >= 0 && $avg < 10:
                    return "XXXX";
                    break;
                case $avg >= 10 && $avg < 20:
                    return "XXXXXX";
                    break;
                case $avg >= 20 && $avg < 30:
                    return "XXXXXXXX";
                    break;
                case $avg >= 30 && $avg < 40:
                    return "XXXXXXXXX";
                    break;
                case $avg >= 40 && $avg < 50:
                    return "XXXXXXXXXXXXX";
                    break;
                case $avg >= 60 && $avg < 70:
                    return "XXXXXXXXXXXXXXXXXX";
                    break;
            }
        }
    @endphp
    <table style="width: 100%;padding:0%;margin:0%;border-spacing:0;">
        <thead>
            <tr style="padding: 0;margin:0;">
                <th colspan="12">
                    <h2 style="padding: 0; margin: 0;">SERVICE RECORD</h2>
                </th>
            </tr>
            <tr>
                <th colspan="12" style="font-weight: normal; font-size: 7pt; font-style: italic;">(To be Accomplished By Employer)</th> <br>
            </tr>
            <tr>
                <th style="height: 10px;"></th>
            </tr>
            <tr style="">
                <th colspan="1" style="text-align: left; font-size: 10pt; font-weight: normal;">
                    NAME :
                    <span style="float: right; font-weight: normal; font-size: 15pt;"></span>
                </th>
                <th colspan="2" style="text-align: left; font-weight: bold; font-size: 10pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                    {{ $employee->surname }}
                </th>
                <th colspan="2" style="text-align: left; font-weight: bold; font-size: 10pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                    {{ $employee->firstname }} {{ $employee->nameextension }}
                </th>
                <th colspan="3" style="text-align: left; font-weight: bold; font-size: 10pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                    {{ $employee->middlename }}
                </th>
                <th colspan="3" style="text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                    (If married woman, give also full maiden name)
                </th>
            </tr>
            <tr>
                <th colspan="1" style="text-align: left; font-size: 10pt; font-weight: normal;">

                    <span style="float: right; font-weight: normal; font-size: 15pt;"></span>
                </th>
                <th colspan="2" style="text-align: left; font-size: 7pt; text-align: center;">
                    (Surname)
                </th>
                <th colspan="2" style="text-align: left; font-size: 7pt; text-align: center;">
                    (Given Name)
                </th>
                <th colspan="3" style="text-align: left; font-size: 7pt; text-align: center;">
                    (Middle Name)
                </th>
                <th colspan="3" style="text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                </th>
            </tr>
            <tr style="">

            </tr>
            <tr style="">
                <th colspan="1" style="text-align: left; font-size: 10pt; font-weight: normal;">
                    BIRTH :
                    <span style="float: right; font-weight: normal; font-size: 15pt;"></span>
                </th>
                <th colspan="2" style="text-align: left; font-weight: bold; font-size: 10pt; border-bottom: solid 1px; text-align: center;">
                    {{ formatbirthDate($employee->birthdate) }}
                </th>
                <th colspan="5" style="text-align: left; font-weight: bold; font-size: 10pt; border-bottom: solid 1px; text-align: center;">
                    {{ $employee->birthplace }}
                </th>
                <th colspan="3" style=" text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                    (Data herein should be checked from birth or baptismal certificate or some other reliable documents)
                </th>
            </tr>
            <tr style="">
                <th colspan="1" style="text-align: left; font-size: 10pt; font-weight: normal;">

                    <span style="float: right; font-weight: normal; font-size: 15pt;"></span>
                </th>
                <th colspan="2" style="text-align: left; font-size: 7pt; text-align: center;">
                    (Date)
                </th>
                <th colspan="5" style="text-align: left; font-size: 7pt; text-align: center;">
                    (Place)
                </th>
                <th colspan="3" style="text-align: left; font-size: 7pt; text-align: center;">
                </th>
            </tr>
            <tr>
                <th colspan="12" style=" text-text-align: center; font-weight: normal; font-size: 10pt; font-style: italic;">
                    This is to certify that the employee named hereinabove actually rendered services in this Office as shown by the service record below, each line of which is supported by appointment and other papers actually issued by this office and approved by the authorities concerned.
                </th>
            </tr>
            <tr style="font-size: 10px;">
                <th colspan="2" style="border: dashed 2px; ">SERVICE</th>
                <th colspan="3" style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;">RECORD OF APPOINTMENT</th>
                <th colspan="2" style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;">OFFICE ENTITY / DIVISION</th>
                <th colspan="1" style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px; border-bottom: none;">Leave of</th>
                <th colspan="3" style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;">SEPARATION</th>
            </tr>
            <tr style="font-size: 10px;">
                <th style="border-left: dashed 2px; border-right: dashed 2px; border-bottom: dashed 2px; width: 15px;">From</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 15px;">To</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 70px;">Designation<br>(Positon)</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 0px;">Status</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 10px;">Salary<br>(P.A.)</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 50px; ">Station/ <br>Place<br>Assignment</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 20px;">Branch</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 20px; border-top: none;">Absences w/o<br>Pay</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 10px;">Re-<br>marks</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 20px; ">Date</th>
                <th style="border-right: dashed 2px; border-bottom: dashed 2px; width: 20px; ">Cause</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($data as $key => $record)
                    <tr style="border: solid 1px" class="text-center">
                        <td style="border-left: 1px solid; border-right: 1px solid; text-align: center; white-space: nowrap; font-size: 11px; vertical-align: middle;padding:0%">{{ format_date($record->from) }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: middle;">{{ format_date($record->to) }}</td>
                        <td style="border-right: 1px solid; text-align: center; padding: 0;font-size: 11px;vertical-align: middle;">
                            {{$record->position}}
                        </td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: middle;">{{ $record->status }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: middle;">{{ $record->salary }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: middle;">{{ $record->station }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: middle;">{{ $record->branch }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: middle;">{{ $record->pay }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: middle;white-space: nowrap;">{{ $record->remark }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: middle;white-space: nowrap;">{{ $record->date }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: middle;white-space: nowrap;">{{ $record->cause }}</td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
        <tfoot style="bottom: 0px;">
            <tr>
                <td style="border-top: dashed 2px;border-left: dashed 2px; border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">{{ spacer($avg) }}</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXXXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXXX</td>
                <td style="border-top: dashed 2px;border-right: dashed 2px; border-bottom: dashed 2px;text-align: center;">XXX</td>
            </tr>
            <tr >
                <td style="border-left: 1px solid; border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 13px;">NOTE:</td>
                <td colspan="3" style="border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 10pt;">{{ $sr->note }}</td>
                <td style="border-bottom: 1px solid"></td>
                <td colspan="2" style="border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 13px;">{{ $employee->retirement_date ? 'Date Retired:' : ''}}</td>
                <td colspan="2" style="word-wrap: break-word;border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 13px;">{{ $employee->retirement_date ? $employee->retirement_date : '' }}</td>
                <td style="border-bottom: 1px solid;border-right: 1px solid;"></td>
            </tr>
            <tr>
                <th colspan="11" style="height: 10px;">

                </th>
            </tr>
            <tr>
                <td colspan="5" style="font-size: 16pt; ">

                </td>
                <th colspan="6" style="font-size: 10pt;">
                    Certified Correct:
                </th>
            </tr>
            <tr>
                <td colspan="11" style="font-size: 16pt; height: 30px;">

                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: 10pt; border-bottom: solid 1px; text-align: center;">
                {{ format($sr->dateCertified) }}
                </td>
                <td colspan="2" style="font-size: 10pt;">
                </td>
                <td colspan="6" style="font-size: 10pt; font-weight: bold; text-align: center; border-bottom: 1px solid">
                    {{ $certName }}
                </td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: 10pt; text-align: center;">
                    Date
                </td>
                <td colspan="2" style="font-size: 10pt;">
                </td>
                <td colspan="6" style="font-size: 10pt; text-align: center;">
                    {{ $certPos }}
                    <br>

                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 10pt;">
                    O.R. NO.
                </td>
                <td colspan="2" style="font-size: 10pt;">
                    : {{ $sr->ORNo }}
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 10pt; ">
                    Date Issued
                </td>
                <td colspan="2" style="font-size: 10pt;">
                    : {{ $sr->dateIssued }}
                </td>
                <td colspan="2" style="font-size: 10pt;">
                </td>
                <td colspan="5" style="font-size: 8pt; font-weight: bold;">
                    Prepared By:
                </td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 10pt; t">
                    Amount
                </td>
                <td colspan="2" style="font-size: 10pt;">
                    : {{ $sr->amount }}
                </td>
                <td colspan="1" style="font-size: 10pt;">
                </td>
                <td colspan="6" style="font-size: 8pt; font-weight: bold;text-align: center;">
                    {{ auth()->user()->name }}
                </td>
            </tr>
            <tr>
                <td colspan="12" style="font-size: 8pt;color:grey;padding-top:20px;">
                    This is a System Generated Report
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

