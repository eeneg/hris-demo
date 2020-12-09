<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="{{ asset('css/id.css') }}" rel="stylesheet">

    </head>
    <body>

        <div class="container-fluid" style="display: flex;" >
            {{-- {{ $employee->firstname }} --}}

            <div style=" border: solid 1px; width: 204px; height: 324.768px; text-align: center;">
                <img src="./storage/employee_id_files/small-id/{{ $dept }}.jpg" alt="logo" width="100%" height="100%" style="position: absolute">
                <div style="position: absolute;">
                    <img class="img-id" src="./storage/employee_id_files/prof.jpg" alt="logo" style="position: absolute; border-radius: 40px; width: 80px; height: 80px;">
                </div>
                <div class="centered">{!! $employee->firstname.' '.$employee->middlename[0].'. '.$employee->surname.($employee->nameextension !== '' ? ' '.$employee->nameextension : '') !!}
                    <br>
                    <p style="margin-top: 0px; font-weight:400 !important; font-size: 8px !important; color: #1f1f1f;"> {{ $position->title }} </p>
                </div>

                <div class="centered4">
                    <img class="img-id2" src="data:image/png;base64,'{{ DNS1D::getBarcodePNG(str_replace(' ', '%0A', $code), 'C93') }}'" alt="barcode" style="width: 100%; height: 100%;">
                </div>

            </div>

            <div class="big" style=" border: solid 1px; width: 355.2px; height: 499.2px; text-align: center;">
                <img src="./storage/employee_id_files/big-id/{{ $dept }}.jpg" alt="logo" width="100%" height="100%" style="position: absolute">
                <img class="big-id" src="./storage/employee_id_files/prof.jpg" alt="logo" style="position: absolute; border-radius: 61px; width: 122px; height: 122px;">
                <img class="qr-code" src="data:image/png;base64,'{{ DNS2D::getBarcodePNG($qrcode, 'QRCODE') }}'" alt="qr-code" style="position: absolute; width: 72px; height: 72px;">
                <div class="centered-big-firstname">
                    <span style="margin-top: 0px;">
                        {{ $employee->firstname }}
                    </span>
                </div>
                <div class="centered-big-surname">
                    <span style="margin-top: 0px;">
                        {{ $employee->middlename.' '.$employee->surname.($employee->nameextension !== '' ? ' '.$employee->nameextension : '') }}
                    </span>
                </div>
                <div class="centered-big-position">
                    <span style="margin-top: 0px;">
                        {{ $position->title }}
                    </span>
                </div>
                <div class="centered-big-idNumber">
                    <span style="margin-top: 0px;">
                        I.D No: 6969XXX
                    </span>
                </div>
            </div>


        </div>
        <div class="page_break"></div>
        <div class="container-fluid" style="display: flex;" >
            <div style=" border: solid 1px; width: 355.2px; height: 499.2px; text-align: center;">
                <img src="./storage/employee_id_files/big-id/{{ $dept }}.jpg" alt="logo" width="100%" height="100%" style="position: absolute">
                <img class="big-id" src="./storage/employee_id_files/prof.jpg" alt="logo" style="position: absolute; border-radius: 61px; width: 122px; height: 122px;">
                <img class="qr-code" src="data:image/png;base64,'{{ DNS2D::getBarcodePNG($qrcode, 'QRCODE') }}'" alt="qr-code" style="position: absolute; width: 72px; height: 72px;">
                <div class="centered-big-firstname">
                    <span style="margin-top: 0px;">
                        {{ $employee->firstname }}
                    </span>
                </div>
                <div class="centered-big-surname">
                    <span style="margin-top: 0px;">
                        {{ $employee->middlename.' '.$employee->surname.($employee->nameextension !== '' ? ' '.$employee->nameextension : '') }}
                    </span>
                </div>
                <div class="centered-big-position">
                    <span style="margin-top: 0px;">
                        {{ $position->title }}
                    </span>
                </div>
                <div class="centered-big-idNumber">
                    <span style="margin-top: 0px;">
                        I.D No: 6969XXX
                    </span>
                </div>
            </div>
        <div style="float: right; border: solid 1px; width: 204px; height: 324.768px;">

            <img src="./storage/employee_id_files/back.jpg" alt="logo" style="position: absolute; width: 100%; height: 100%; ">
            <div class="sign">
                <img src="./storage/employee_id_files/signatures/{{ $contact->signature }}.png" alt="sign" style="position: absolute; width: 100%; height: 100%; ">
            </div>
            <div class="centered-back" style="text-align: center;">
                {!! $employee->firstname.' '.$employee->middlename[0].'. '.$employee->surname.($employee->nameextension !== '' ? ' '.$employee->nameextension : '') !!}
                <br>
                <p style="margin-bottom: 0px; margin-top: 0px; font-weight:400 !important; font-size: 8px !important; color: #1f1f1f; line-height: 1;"> {{ $position->title }} </p>
            </div>
            <div class="centered-back2" style="text-align: center;">
                ID NO :     6969XXX
            </div>
            <div class="centered-back3" style=" width: 51px; height: 51px; position: absolute;">
                <img src="./storage/employee_id_files/prof.jpg" alt="logo" style="position: absolute;  width: 50px; height: 50px;">
            </div>
            <div class="centered-back4" style="text-align: left;">
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">Birthdate: &nbsp;&nbsp; {{ \Carbon\Carbon::parse($employee->birthdate)->format('F d, Y') }}</p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">Phone: &nbsp;&nbsp; {{ $employee->cellphone }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">Address: &nbsp;&nbsp; {{ $employee->permanentaddress  }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">GSIS: &nbsp;&nbsp; {{ $employee->gsis }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">TIN: &nbsp;&nbsp; {{ $employee->tin  }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">PHIC ID No.: &nbsp;&nbsp;{{ $employee->philhealth  }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">HDMF ID No.: &nbsp;&nbsp; {{ $employee->pagibig  }} </p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f;">Blood Type: &nbsp;&nbsp; {{ $employee->bloodtype  }} </p>
            </div>
            <div class="centered-back5" style="text-align: center;">
                <p style="margin-bottom: 0px; margin-top: 0px; color: #c15640; font-weight: bold;">{{ $contact->name }}</p>
                <p style="margin-bottom: 0px; margin-top: 0px; color: #1f1f1f; font-size: 6px;">{{ $contact->address }}</p>
            </div>
        </div>
        </div>
    </body>
</html>
