<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="{{ asset('css/reports.css') }}" rel="stylesheet">
        <style>
            @page {
                size: landscape;
                margin: 0;
            }
            @media print {
                html, body {
                    width: 297mm;
                    height: 210mm;
                }
                /* ... the rest of the rules ... */
            }
            .ticket {
                margin: 0 !important;
                padding: 0 !important;
                /* background-size: contain; */
                border: 1px solid rgb(49, 49, 49);
                width: 50%;
                float: left;
            }

            .ticket img {
                margin: 0 !important;
                padding: 0 !important;
                border: 1px solid black;
                width: 100%;
                /* visibility: hidden !important; */
            }
            p {
                font-weight: bold !important;
            }
        </style>

    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                @foreach ($plantillacontents as $person)
                <div class="col-md-6 ticket">
                    <img src="{{ asset('storage/project_files/Raffle.jpg') }}" alt="Raffle Ticket" style="">
                    <div style="position: absolute !important; top: 95px !important; left: 43px !important;width: 260px;">
                        <p style="font-size: 1.3rem;margin: 0;">{{ $person['old_number'] }}</p>

                        <div style="width: 100%;height: 2.6rem;display: table;margin: 0 0 5px 15px;">
                            <p style="font-size: 1.3rem;line-height: 1.3rem;display: table-cell;vertical-align: bottom;">{{ $person['name'] }}</p>
                        </div>

                        <div style="width: 100%;height: 2.6rem;display: table;margin: 0 0 0 15px;">
                            <p style="font-size: 1.3rem;line-height: 1.3rem;display: table-cell;vertical-align: bottom;">{{ $person['office_title'] }}</p>
                        </div>
                    </div>
                    <div style="position: absolute !important; top: 97px !important; left: 385px !important;width: 150px;">
                        <p style="font-size: 1rem;margin: 0;">{{ $person['old_number'] }}</p>
                        
                        <div style="width: 100%;height: 2rem;display: table;margin: 9px 0 11px 16px;">
                            <p style="font-size: 1rem;line-height: 1rem;display: table-cell;vertical-align: bottom;">{{ $person['name'] }}</p>
                        </div>

                        <div style="width: 100%;height: 2rem;display: table;margin: 0 0 0 19px;">
                            <p style="font-size: 1rem;line-height: 1rem;display: table-cell;vertical-align: bottom;">{{ $person['office_title'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
