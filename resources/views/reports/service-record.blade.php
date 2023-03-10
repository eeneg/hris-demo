<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script>
</script>
<body>
    <table class="table table-striped text-nowrap custom-table text-center w-100" style="border: solid 1px">
        <thead>
            <tr>
                <th colspan="1" style="border: solid 1px"></th>
                <th colspan="2" style="border: solid 1px">Service</th>
                <th colspan="3" style="border: solid 1px">Record of Appointment</th>
                <th colspan="2" style="border: solid 1px">Office Entity / Division</th>
                <th colspan="1" style="border: solid 1px">Leave of Absences</th>
                <th colspan="3" style="border: solid 1px">Separation</th>
            </tr>
            <tr>
                <th style="border: solid 1px">#</th>
                <th style="border: solid 1px">From</th>
                <th style="border: solid 1px">To</th>
                <th style="border: solid 1px">Designation<br>(Positon)</th>
                <th style="border: solid 1px">Status</th>
                <th style="border: solid 1px">Salary</th>
                <th style="border: solid 1px">Station/ <br>Place Assignment</th>
                <th style="border: solid 1px">Branch</th>
                <th style="border: solid 1px">Absences w/o<br>Pay</th>
                <th style="border: solid 1px">Remarks</th>
                <th style="border: solid 1px">Date</th>
                <th style="border: solid 1px">Cause</th>
            </tr>
        </thead>
        <tbody>
            @php
                function formatDate($date)
                {
                    return Carbon\Carbon::parse($date)->format('m/d/y');
                }
            @endphp
            @foreach ($data as $key => $record)
                <tr style="border: solid 1px">
                    <td style="border: solid 1px">{{$key + 1}}</td>
                    <td style="border: solid 1px">{{ formatDate($record->from) }}</td>
                    <td style="border: solid 1px">{{ formatDate($record->to) }}</td>
                    <td style="border: solid 1px">{{ $record->position_title }}</td>
                    <td style="border: solid 1px">{{ $record->status }}</td>
                    <td style="border: solid 1px">{{ $record->salary }}</td>
                    <td style="border: solid 1px">{{ $record->dept_name }}</td>
                    <td style="border: solid 1px">{{ $record->branch }}</td>
                    <td style="border: solid 1px">{{ $record->pay }}</td>
                    <td style="border: solid 1px">{{ $record->remark }}</td>
                    <td style="border: solid 1px">{{ formatDate($record->date) }}</td>
                    <td style="border: solid 1px">{{ $record->cause }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
