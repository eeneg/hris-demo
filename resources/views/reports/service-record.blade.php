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
    <table class="table table-striped text-nowrap custom-table text-center w-100">
        <thead>
            <tr>
                <th colspan="1" class="border"></th>
                <th colspan="2" class="border">Service</th>
                <th colspan="3" class="border">Record of Appointment</th>
                <th colspan="2" class="border">Office Entity / Division</th>
                <th colspan="1" class="border">Leave of Absences</th>
                <th colspan="3" class="border">Separation</th>
                <th colspan="1" class="border"></th>
            </tr>
            <tr>
                <th class="border">#</th>
                <th class="border">From</th>
                <th class="border">To</th>
                <th class="border">Designation<br>(Positon)</th>
                <th class="border">Status</th>
                <th class="border">Salary</th>
                <th class="border">Station/ <br>Place Assignment</th>
                <th class="border">Branch</th>
                <th class="border">Absences w/o<br>Pay</th>
                <th class="border">Remarks</th>
                <th class="border">Date</th>
                <th class="border">Cause</th>
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
                <tr>
                    <td>{{$key + 1}}</td>
                    <td>{{ formatDate($record->from) }}</td>
                    <td>{{ formatDate($record->to) }}</td>
                    <td>{{ $record->position_title }}</td>
                    <td>{{ $record->status }}</td>
                    <td>{{ $record->salary }}</td>
                    <td>{{ $record->dept_name }}</td>
                    <td>{{ $record->branch }}</td>
                    <td>{{ $record->pay }}</td>
                    <td>{{ $record->remark }}</td>
                    <td>{{ formatDate($record->date) }}</td>
                    <td>{{ $record->cause }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
