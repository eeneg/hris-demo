<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Laravel</title>
		<style>
			.tableM {
				width: 100%;
				padding: 0;
				margin: 0;
				border-spacing: 0;
			}

			.titleHeader {
				width: 100%;
				text-align: center;
				margin: 0;
				line-height: 2px;
			}

			.divThead {
				border: solid black 1px;
			}

			.th2 {
				border: solid black 2px;
			}
            .tdHeight{
                height: 70px;
                padding-top: 0px;
                padding-bottom: 0px;
            }
            .pHeight{
                margin-top: 0px;
                margin-bottom: 0px;
            }
		</style>
	</head>
	<body id="po-body" style="width: 100%">
        <footer style="position: fixed; left: 0; margin-top: 930px; height: 200px; width: 100%;">
			<div style="display: table;">
				<thead style="width: 100%; border: solid black 1px;">
					        <th style="font-size: 14pt; font-weight: normal; height: 20px; width: 30px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal;  width: 30px;  border: solid black 2px; border-top: none; border-right: none; border-left: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 260px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"></th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; "></th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
                            <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
                            <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
				</thead>
				<tfoot style="top: 0; bottom: 50; width: 100%;">
                    <thead style="width: 100%; border: solid black 1px;">
                        <th style="font-size: 14pt; font-weight: normal; height: 20px; width: 30px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal;  width: 30px;  border: solid black 2px; border-top: none; border-right: none; border-left: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 260px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; "></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
                        <th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-left: none; border-top: none; "></th>
            </thead>
                    <tr>
						<td colspan="11" style="font-size: 16pt; height: 50px;">

						</td>
					</tr>
					<tr>
                        <td colspan="6" style="font-size: 16pt;">
                            Prepared by:
                        </td>
                        <td colspan="5" style="font-size: 16pt;">
                            Reviewed by:
                        </td>
					</tr>
                    <tr>
						<td colspan="11" style="font-size: 16pt; height: 50px;">

						</td>
					</tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="2" style="font-size: 16pt; font-weight: bold; text-align: center;">
                             RAUL D. RAUT, ENP, JD
                        </td>
                        <td>
                        </td>
                        <td colspan="4" style="font-size: 16pt; font-weight: bold; text-align: center;">
                            DESSAMIE H. BUAT-SANCHEZ, CPA
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="2" style="font-size: 16pt; text-align: center;">
                            PGDH-Provincial Human Resource Management Officer
                        </td>
                        <td>
                        </td>
                        <td colspan="4" style="font-size: 16pt; text-align: center;">
                            PGDH-Provincial Budget Officer
                        </td>
                    </tr>
                    <tr>
						<td colspan="9" style="font-size: 16pt; height: 50px;">

						</td>
					</tr>
                    <tr>
                        <td colspan="6">
                        </td>
                        <td colspan="5" style="font-size: 16pt;">
                            Approved by:
                        </td>
					</tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="6" style="font-size: 16pt; font-weight: bold; text-align: center;">
                            YVONNE R. CAGAS
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="6" style="font-size: 16pt; text-align: center;">
                            Provincial Governor
                        </td>
                    </tr>
					<tr>
						<td colspan="11" style="font-size: 14px; height: 70px;">

						</td>
					</tr>
					{{-- <tr>
						<td colspan="9" style="font-size: 10pt; text-align: center;">
							*Duly created under SP Ordinance No. 20-68 dated December 10, 2020 "Enacting the Revised Davao del Sur Investments & Incentive Code of 2020"
						</td>
					</tr> --}}
				</tfoot>
			</div>
		</footer>
		<main role="main" style="width: 100%; font-size: 20px;">
			<div style="display: table; ">
				<div style=" width: 100%; margin-bottom: 20rem;">
					<table class="tableM" style=" margin-bottom: 500rem; height: 200px; width: 100%; border: solid red 1px; overflow: hidden;">
                        <thead style="width: 100%;">
                            <th colspan="11">
                                <p style="line-height: 1;">
                                <h2 style="padding: 0; margin: 0;">SERVICE RECORD</h2> <br>
                                <span style="font-weight:normal; margin-top: 0;">(To be Accomplished By Employer)</span>
                            </p>
                            </th>
                        </thead>
                            <thead style="margin-bottom: 20px;">
                                <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">
                                    NAME :
                                    <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                                </th>
                                <th colspan="2" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                                    ABAWAG
                                </th>
                                <th colspan="2" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                                    LAVENIA
                                </th>
                                <th colspan="3" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-transform:uppercase; text-align: center;">
                                    ABAWAG
                                </th>
                                <th colspan="3" style="text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                                    (If married woman, give also full maiden name)
                                </th>

                            </thead>
                        <thead style="margin-bottom: 20px;">
                            <th colspan="2" style="text-align: left; font-size: 12pt; font-weight: normal;">

                                <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                            </th>
                            <th colspan="2" style="text-align: left; font-size: 7pt; text-align: left;">
                                (Surname)
                            </th>
                            <th colspan="2" style="text-align: left; font-size: 7pt; text-align: left;">
                                (Given Name)
                            </th>
                            <th colspan="2" style="text-align: left; font-size: 7pt; text-align: left;">
                                (Middle Name)
                            </th>
                            <th colspan="3" style="text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                            </th>
                        </thead >
                        <thead style="margin-bottom: 20px;">
                            <th colspan="1" style="text-align: left; font-size: 12pt; font-weight: normal;">
                                BIRTH :
                                <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                            </th>
                            <th colspan="3" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-align: center;">
                                March 12, 1987
                            </th>
                            <th colspan="4" style="text-align: left; font-weight: bold; font-size: 12pt; border-bottom: solid 1px; text-align: center;">
                                Digos City, Davao del Sur
                            </th>
                            <th colspan="3" style="margin-bottom: 20px; text-align: left; font-weight: normal; font-size: 7pt; font-style: italic;">
                                (Data herein should be checked from birth or baptismal certificate or some other reliable documents)
                            </th>
                        </thead >
                        <thead style="margin-bottom: 20px;">
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
                        </thead>
                        <thead>
                            <th colspan="11" style="height: 10px;">

                            </th>
                        </thead>
                        <thead>
                            <th colspan="11" style="height: 20px; text-text-align: center; font-weight: normal; font-size: 10pt; font-style: italic;">
                                This is to certify that the employee named hereinabove actually rendered services in this Office as shown by the service record below, each line of which is supported by appointment and other papers actually issued by this office and approved by the authorities concerned.
                            </th>
                        </thead>
                        <thead>
                            <th colspan="11" style="height: 10px;">

                            </th>
                        </thead>
						<thead style=" width: 100%;">
							<th colspan="2" style="font-size: 12pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;">SERVICE</th>
                            <th colspan="3" style="font-size: 12pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;">RECORD OF APPOINTMENT</th>
                            <th colspan="2" style="font-size: 12pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;">Office Entity/Division</th>
							<th colspan="1" style="font-size: 12pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; ">Leave of</th>
                            <th colspan="3" style="font-size: 12pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-left: none; ">Separation</th>
						</thead>
						<thead style="width: 100%;">
							<th style="font-size: 14pt; font-weight: normal; height: 20px; border: solid black 2px; border-top: none; border-right: none;">Old</th>
							<th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-top: none; border-right: none; border-left: none;">New</th>
							<th style="font-size: 14pt; font-weight: normal; border: solid black 2px; border-top: none; border-right: none;">(Position)</th>
							<th style="font-size: 14pt; font-weight: normal; border: solid black 2px; border-top: none; border-right: none;">Status</th>
							<th style="font-size: 14pt; font-weight: normal; border: solid black 2px; border-top: none; border-right: none;">Salary</th>
							<th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-top: none; border-right: none;">Station/Place</th>
							<th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-top: none; border-right: none;">Branch</th>
							<th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-top: none; ">w/o Pay</th>
							<th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-left: none; border-top: none; ">Remarks</th>
                            <th style="font-size: 14pt; font-weight: normal;  border: solid black 2px; border-left: none; border-top: none; ">Date</th>
                            <th style="font-size: 14pt; font-weight: normal; border: solid black 2px; border-left: none; border-top: none; ">Cause</th>
						</thead>
						<tbody style="margin-bottom: 200px; width: 100%;">
                            {{-- Department Data --}}
							{{-- <tr>
								<td style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td colspan="2" style="text-align: left; font-style:italic; font-weight: bold; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"> A. OFFICE OF THE PROVINCIAL WARDEN </td>

								<td style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></td>
								<td style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none;"></td>
							</tr> --}}
                            {{-- Table Data --}}
                                @php
                                function formatDate($date)
                                {
                                    return Carbon\Carbon::parse($date)->format('m/d/y');
                                }
                            @endphp
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            @foreach ($data as $key => $record)
                            <tr style="border: solid 1px; word-wrap:break-word;">
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->from) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->to) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->position_title }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->status }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->salary }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->dept_name }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->branch }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->pay }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->remark }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ formatDate($record->date) }}</td>
                                    <td style="border: dashed 2px; font-size: 12pt;">{{ $record->cause }}</td>
                            </tr>
                            @endforeach
                            <tr style="font-size: 12pt;">
                                <td style="border: dashed 2px;">XXXX</td>
                                <td style="border: dashed 2px;">XXX</td>
                                <td style="border: dashed 2px;">XXX</td>
                                <td style="border: dashed 2px;">XXXX</td>
                                <td style="border: dashed 2px;">XX</td>
                                <td style="border: dashed 2px;">XXXXXX</td>
                                <td style="border: dashed 2px;">XXX</td>
                                <td style="border: dashed 2px;">XXXX</td>
                                <td style="border: dashed 2px;">XXXX</td>
                                <td style="border: dashed 2px;">XXX</td>
                              <td style="border: dashed 2px;">XXX</td>
                            </tr>
                            <tr >
                                <td style="border: dashed 2px; height: 20px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                              <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                            </tr>
                            <tr>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px; text-align: center; font-weight: bold; font-size: 12pt;">NOTE:</td>
                                <td style="border: dashed 2px; text-align: center; font-weight: bold; font-size: 12pt;">STILL IN SERVICE.</td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                                <td style="border: dashed 2px;"></td>
                            </tr>

						</tbody>
                        <tfoot style=" bottom: 0; width: 100%; position: fixed; display:table;">
                            <tr>
                                <td colspan="11" style="height: 50px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" style="font-size: 16pt; height: 50px;">

                                </td>
                                <td colspan="6" style="font-size: 16pt;">
                                    Certified Correct:
                                </td>
                            </tr>
                            <tr>
                                <td colspan="11" style="font-size: 16pt; height: 50px;">

                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="font-size: 16pt; border-bottom: solid 1px; text-align: center;">
                                    November 9, 2021
                                </td>
                                <td colspan="2" style="font-size: 16pt;">
                                </td>
                                <td colspan="6" style="font-size: 16pt; font-weight: bold; text-align: center;">
                                    LOURDES H. BUAT
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="font-size: 16pt; text-align: center;">
                                    Date
                                </td>
                                <td colspan="2" style="font-size: 16pt;">
                                </td>
                                <td colspan="6" style="font-size: 16pt; text-align: center;">
                                    Administrative Officer V
                                    <br>
                                    (HRMO III)
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-size: 12pt; ">
                                    O.R. NO.
                                </td>
                                <td colspan="2" style="font-size: 12pt;">
                                    : 9037812
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-size: 12pt; ">
                                    Date Issued
                                </td>
                                <td colspan="2" style="font-size: 12pt;">
                                    : 11/09/2021
                                </td>
                            </tr>
                            <tr>
                                <td colspan="1" style="font-size: 12pt; t">
                                    Amount
                                </td>
                                <td colspan="2" style="font-size: 12pt;">
                                    : P50.00
                                </td>
                            </tr>
                            <tr>
                                <td colspan="9" style="font-size: 16pt; height: 50px;">

                                </td>
                            </tr>

                        </tfoot>
					</table>

				</div>

			</div>

		</main>
		<script type="text/php">

        </script>
	</body>

</html>
