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
                margin-bottom: 200px; !important

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
    @endphp
    <main style="">
        @foreach ($data as $item)
        <table class="tableM" style=" margin-bottom: 200rem; width: 100%;">
            <thead>
                <tr>
                    <th colspan="12">
                        <p style="line-height: 0.5;">
                        <h2 style="padding: 0; margin: 0;">SERVICE RECORD</h2> <br>
                        <span style="font-weight:normal; margin-top: 0;">(To be Accomplished By Employer)</span>
                    </p>
                    </th>
                </tr>
                <tr style="margin-bottom: 20px; height: 20px;">
                    <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">
                        NAME :
                        <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                    </th>
                    <th colspan="2" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                        {{ $employee->surname }}
                    </th>
                    <th colspan="2" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                        {{ $employee->firstname }}
                    </th>
                    <th colspan="3" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                        {{ $employee->middlename }}
                    </th>
                    <th colspan="3" style="text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                        (If married woman, give also full maiden name)
                    </th>
                </tr>
                <tr style="margin-bottom: 20px;">
                    <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">

                        <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
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
                <tr style="height: 20px;">
                </tr>
                <tr style="margin-bottom: 20px;">
                    <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">
                        BIRTH :
                        <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                    </th>
                    <th colspan="2" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-align: center;">
                        {{ formatbirthDate($employee->birthdate) }}
                    </th>
                    <th colspan="5" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-align: center;">
                        {{ $employee->birthplace }}
                    </th>
                    <th colspan="3" style="margin-bottom: 20px; text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                        (Data herein should be checked from birth or baptismal certificate or some other reliable documents)
                    </th>
                </tr>
                <tr style="margin-bottom: 20px;">
                    <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">

                        <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
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
                <tr style="height: 20px;">
                </tr>
                <tr>
                    <th colspan="12" style="height: 20px; text-text-align: center; font-weight: normal; font-size: 10pt; font-style: italic;">
                        This is to certify that the employee named hereinabove actually rendered services in this Office as shown by the service record below, each line of which is supported by appointment and other papers actually issued by this office and approved by the authorities concerned.
                    </th>
                </tr>
                <tr style="height: 20px;">
                </tr>
            </thead>
            <tbody>
                <thead style=" font-size: 12px;  word-wrap:break-word; border: dashed 2px; border-style: dashed;">

                    <th colspan="2" style="border: dashed 2px; height: 20px;">SERVICE</th>
                    <th colspan="3" style="border: dashed 2px;">RECORD OF APPOINTMENT</th>
                    <th colspan="2" style="border: dashed 2px;">OFFICE ENTITY / DIVISION</th>
                    <th colspan="1" style="border: dashed 2px; border-bottom: none;">Leave of</th>
                    <th colspan="3" style="border: dashed 2px;">SEPARATION</th>

                </thead>
            <thead style="font-size: 12px;">

                    <th style="border: dashed 2px; width: 20px;">From</th>
                    <th style="border: dashed 2px; width: 20px;">To</th>
                    <th style="border: dashed 2px; width: 70px;">Designation<br>(Positon)</th>
                    <th style="border: dashed 2px; width: 20px;">Status</th>
                    <th style="border: dashed 2px; width: 20px;">Salary(P.A.)</th>
                    <th style="border: dashed 2px; width: 20px; ">Station/ <br>Place Assignment</th>
                    <th style="border: dashed 2px; width: 20px;">Branch</th>
                    <th style="border: dashed 2px; width: 20px; border-top: none;">Absences w/o<br>Pay</th>
                    <th style="border: dashed 2px; width: 20px;">Remarks</th>
                    <th style="border: dashed 2px; width: 20px; ">Date</th>
                    <th style="border: dashed 2px; width: 20px; ">Cause</th>

            </thead>
            <tr>
                @foreach ($item as $key => $record)
                <tr style="border: solid 1px" class="text-center">
                    <td style="border-left: 1px solid; border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->from }}</td>
                    <td style="border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->to }}</td>
                    <td style="border-right: 1px solid; text-align: center;">
                        {{ $record->position }}
                    </td>
                    <td style="border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->status }}</td>
                    <td style="border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->salary }}</td>
                    <td style="border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->station }}</td>
                    <td style="border-right: 1px solid; text-align: center;">{{ $record->branch }}</td>
                    <td style="border-right: 1px solid; text-align: center; white-space: nowrap;">{{ $record->pay }}</td>
                    <td style="border-right: 1px solid; text-align: center;">{{ $record->remark }}</td>
                    <td style="border-right: 1px solid; text-align: center;">{{ $record->date }}</td>
                    <td style="border-right: 1px solid; text-align: center;">{{ $record->cause }}</td>
                </tr>
                @endforeach
            </tr>
            <tr >
                <td style="border: dashed 2px;">XXXX</td>
                <td style="border: dashed 2px;">XXXX</td>
                <td style="border: dashed 2px;">XXXXXXXXXXXXXXXX</td>
                <td style="border: dashed 2px;">XXXXXXX</td>
                <td style="border: dashed 2px;">XXXXXXX</td>
                <td style="border: dashed 2px;">XXXXXXXXXXXXXXXX</td>
                <td style="border: dashed 2px;">XXXXXXX</td>
                <td style="border: dashed 2px;">XXXX</td>
                <td style="border: dashed 2px;">XXXX</td>
                <td style="border: dashed 2px;">XXXX</td>
                <td style="border: dashed 2px;">XXXX</td>
            </tr>
            <tr >
                <td style="border-left: 1px solid; height: 20px;"></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style="border-right: 1px solid;"></td>
            </tr>
            <tr >
                <td style="border-left: 1px solid; border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid; text-align: center; font-weight: bold;">NOTE:</td>
                <td colspan="1" style="word-wrap: break-word;border-bottom: 1px solid; text-align: center; font-weight: bold;">{{ $sr->note }}</td>
                <td style="border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid; text-align: center; font-weight: bold;">{{ $employee->retirement_date ? 'Date Retired:' : ''}}</td>
                <td colspan="1" style="word-wrap: break-word;border-bottom: 1px solid; text-align: center; font-weight: bold;">{{ $employee->retirement_date ? $employee->retirement_date : '' }}</td>
                <td style="border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid"></td>
                <td style="border-bottom: 1px solid"></td>
                <td style="border-right: 1px solid; border-bottom: 1px solid"></td>
            </tr>
                <tr>
                    <th colspan="11" style="height: 50px;">

                    </th>
                </tr>
                <tr>
                    <td colspan="5" style="font-size: 16pt; height: 50px;">

                    </td>
                    <th colspan="6" style="font-size: 16pt;">
                        Certified Correct:
                    </th>
                </tr>
                <tr>
                    <td colspan="11" style="font-size: 16pt; height: 50px;">

                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 16pt; border-bottom: solid 1px; text-align: center;">
                      {{ format($sr->dateCertified) }}
                    </td>
                    <td colspan="2" style="font-size: 16pt;">
                    </td>
                    <td colspan="6" style="font-size: 16pt; font-weight: bold; text-align: center;">
                        {{ $certName }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="font-size: 16pt; text-align: center;">
                        Date
                    </td>
                    <td colspan="2" style="font-size: 16pt;">
                    </td>
                    <td colspan="6" style="font-size: 16pt; text-align: center;">
                        {{ $certPos }}
                        <br>

                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 12pt;">
                        O.R. NO.
                    </td>
                    <td colspan="2" style="font-size: 12pt;">
                        : {{ $sr->ORNo }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 12pt; ">
                        Date Issued
                    </td>
                    <td colspan="2" style="font-size: 12pt;">
                        : {{ $sr->dateIssued }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 12pt; t">
                        Amount
                    </td>
                    <td colspan="2" style="font-size: 12pt;">
                        : {{ $sr->amount }}
                    </td>
                </tr>
                <tr>
                    <td colspan="9" style="font-size: 16pt; height: 50px;">

                    </td>
                </tr>
        </tbody>

        </table>
    @endforeach
    </main>
</body>
</html>

