<!DOCTYPE html>
<html>
<head>

</head>
<style>
    .tableM {
                width: 100%;
                padding: 0;
                margin: 0;
                border-spacing: 0;
            }

    @media print {
        footer {page-break-after: always;}
    }
</style>
<body>
    @php
        function format($date){
            if(strtotime($date) !== false)
            {
                return Carbon\Carbon::parse($date)->format('F d, Y');
            }
            return $date;
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
                case $avg > 0 && $avg < 10:
                    return "XXXX";
                    break;
                case $avg > 10 && $avg < 20:
                    return "XXXXXX";
                    break;
                case $avg > 20 && $avg < 30:
                    return "XXXXXXXX";
                    break;
                case $avg > 30 && $avg < 40:
                    return "XXXXXXXXX";
                    break;
                case $avg > 40 && $avg < 50:
                    return "XXXXXXXXXXXXX";
                    break;
                case $avg > 60 && $avg < 70:
                    return "XXXXXXXXXXXXXXXXXX";
                    break;
            }
        }
    @endphp
    <main class="page-break" style="">
        <div style="width: 100%; padding:0; height:0%;text-align:end;">

        </div>
        <table class="tableM html2pdf__page-break" style="width: 100%;">
            <thead>
                <tr>
                    <th colspan="12">
                        <p style="line-height: 0.5;">
                        <h2 style="padding: 0; margin: 0;">SERVICE RECORD</h2> <br>
                        <span style="font-weight:normal; margin-top: 0;">(To be Accomplished By Employer)</span>
                    </p>
                    </th>
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
                        {{ $employee->firstname }}
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
                    <th colspan="3" style="border: dashed 2px;">RECORD OF APPOINTMENT</th>
                    <th colspan="2" style="border: dashed 2px;">OFFICE ENTITY / DIVISION</th>
                    <th colspan="1" style="border: dashed 2px; border-bottom: none;">Leave of</th>
                    <th colspan="3" style="border: dashed 2px;">SEPARATION</th>
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
                        <td style="border-left: 1px solid; border-right: 1px solid; text-align: center; white-space: nowrap; font-size: 11px; vertical-align: bottom;padding:0%">{{ $record->from }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: bottom;">{{ $record->to }}</td>
                        <td style="border-right: 1px solid; text-align: center; padding: 0;font-size: 11px;vertical-align: bottom;">
                            {{$record->position}}
                        </td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: bottom;">{{ $record->status }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: bottom;">{{ $record->salary }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: bottom;">{{ $record->station }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: bottom;">{{ $record->branch }}</td>
                        <td style="border-right: 1px solid; text-align: center; white-space: nowrap;font-size: 11px;vertical-align: bottom;">{{ $record->pay }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: bottom;">{{ $record->remark }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: bottom;">{{ $record->date }}</td>
                        <td style="border-right: 1px solid; text-align: center;font-size: 11px;vertical-align: bottom;">{{ $record->cause }}</td>
                    </tr>
                    @endforeach
                </tr>
            </tbody>
            <tfoot style="bottom: 0;">
                <tr >
                    <td style="border: dashed 2px;text-align: center;">XXX</td>
                    <td style="border: dashed 2px;text-align: center;">XXX</td>
                    <td style="border: dashed 2px;text-align: center;">{{ spacer($avg) }}</td>
                    <td style="border: dashed 2px;text-align: center;">XX</td>
                    <td style="border: dashed 2px;text-align: center;">XXXX</td>
                    <td style="border: dashed 2px;text-align: center;">XXXXX</td>
                    <td style="border: dashed 2px;text-align: center;">XX</td>
                    <td style="border: dashed 2px;text-align: center;">XX</td>
                    <td style="border: dashed 2px;text-align: center;">XX</td>
                    <td style="border: dashed 2px;text-align: center;">XXX</td>
                    <td style="border: dashed 2px;text-align: center;">XXX</td>
                </tr>
                <tr >
                    <td style="border-left: 1px solid; border-bottom: 1px solid"></td>
                    <td style="border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 13px;">NOTE:</td>
                    <td colspan="2" style="border-bottom: 1px solid; text-align: center; font-weight: bold;font-size: 13px;">{{ $sr->note }}</td>
                    <td style="border-bottom: 1px solid"></td>
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
                    <td colspan="11" style="font-size: 16pt; ">

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
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 10pt; t">
                        Amount
                    </td>
                    <td colspan="2" style="font-size: 10pt;">
                        : {{ $sr->amount }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </main>
</body>
</html>

