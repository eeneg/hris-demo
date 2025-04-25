<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <main role="main">
            <div class="col-md-12 report_div">
                <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo" style="top: 20px;">
                <div class="row" style="position:fixed;top:-5px;right:40px;">
                    <p class="m-0 float-right"><small>THIS IS A SYSTEM GENERATED REPORT</small></p>
                </div>
                <div class="row mt-3 mb-5">
                    <div class="col-12 text-center">
                        <h4 class="m-0">Republic of the Philippines</h4>
                        <h4 class="m-0">PROVINCE OF DAVAO DEL SUR</h4>
                        <h5 class="m-0 font-weight-bold">Municipality of Santa Cruz</h5>
                        <h4 class="m-0 font-weight-bold">Human Resource Management Office</h4>
                        <h1 class="m-0 font-weight-bold mt-5">"APPOINTMENT"</h1>
                    </div>
                </div>

                <!-- Reports -->
                <div class="row mb-2">
                    <div class="col-6">
                        <h3 class="m-0"><b>From </b> {{ $from }} to {{ $to }}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Employee</th>
                                    <th>Nature of Appointment</th>
                                    <th>Appointed to</th>
                                    <th>Reckoning Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">{{ $key + 1}}.</td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="font-size: 1rem; text-transform: uppercase;">{{ $value['name'] }}</span>
                                        </td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="text-transform: uppercase;">{{ $value['nature'] }}</span>
                                        </td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="text-transform: uppercase;">{{ $value['appointed_to'] }}</span>
                                            <div style="line-height: 1rem;">
                                                <span style="font-size: 0.8rem;" class="text-muted">Department: {{$value['department']}}</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{$value['reckoning_date']}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <script type="text/php">

        </script>
    </body>
</html>


