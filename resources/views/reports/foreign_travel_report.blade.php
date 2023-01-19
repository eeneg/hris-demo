<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>HTML Table</h2>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Employee</th>
            <th scope="col">Type of Leave</th>
            <th scope="col">Days</th>
            <th scope="col">Inclusive Dates</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $values)
        <tr>
            <th scope="row">{{ $values['name'] }}</th>
            <td>{{ $values['leave_type'] }}</td>
            <td>{{ $values['days'] }}</td>
            <td>{{ $values['inclusive_dates'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


</body>
</html>

