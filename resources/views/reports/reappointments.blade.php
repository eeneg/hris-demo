<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <style>

        </style>

        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>
        <main role="main">
            <div class="col-md-12 report_div">
                <img src="storage/project_files/davsur.png" alt="Agency Logo" class="img-fluid nosi-logo" style="top: 20px;">
                <div class="row" style="position:fixed;top:-5px;right:40px;">
                    <p class="m-0"><small>THIS IS A SYSTEM GENERATED REPORT</small></p>
                </div>
                <div class="row mt-3 mb-5">
                    <div class="col-12 text-center">
                        <h4 class="m-0">Republic of the Philippines</h4>
                        <h4 class="m-0">Province of Davao Del Sur</h4>
                        <h4 class="m-0">Municipality of Santa Cruz</h4>
                        <h4 class="m-0 font-weight-bold">Human Resource Management Office</h4>
                        <h1 class="m-0 font-weight-bold mt-5">"REASSIGNMENT"</h1>
                    </div>
                </div>

                <!-- Reports -->
                <div class="row mb-2">
                    @if ($from && $to)
                    <div class="col-6">
                        <h3 class="m-0"><b>From </b> {{ $from }} to {{ $to }}</h3>
                    </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table table-bordered m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Employee</th>
                                    <th>Assigned From</th>
                                    <th>Reassigned To</th>
                                    <th>Effectivity Date</th>
                                    <th>Termination Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td class="align-middle pt-1 pb-1">{{ $key + 1}}.</td>
                                        <td class="align-middle pt-1 pb-1">
                                            {{-- {{$value}} --}}
                                            <span style="text-transform: uppercase;">{{ $value['firstname'] }} {{ $value['middlename'][0] != null ? $value['middlename'][0] . '.' : null }} {{ $value['surname'] }} {{ $value['nameextension']  }}</span>
                                            <br>
                                            <span style="font-style:italic">{{$value['type']}}</span>
                                        </td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="text-transform: uppercase;">{{ $value['dept_from'] }}</span>
                                        </td>
                                        <td class="align-middle pt-1 pb-1">
                                            <span style="text-transform: uppercase;">{{ $value['dept_to'] }}</span>
                                        </td>
                                        <td>
                                            {{$value['effectivity_date']}}
                                        </td>
                                        <td>
                                            {{$value['termination_date']}}
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


