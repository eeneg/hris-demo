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

        @media print {
            table {page-break-after: always;}
        }
    </style>
</head>
<body>

    <h2>HTML Table</h2>

    @php
        function formatDate($date)
        {
            return Carbon\Carbon::parse($date)->format('m/d/y');
        }
    @endphp

    @foreach ($data as $item)
        <table style="">
            <tr>
                <th>Company</th>
                <th>Contact</th>
            </tr>
            <tr>
                @foreach ($item as $record)
                    <tr style="border: solid 1px; word-wrap:break-word;">
                        <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                        <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                    </tr>
                @endforeach
            </tr>
        </table>
    @endforeach

</body>
</html>

