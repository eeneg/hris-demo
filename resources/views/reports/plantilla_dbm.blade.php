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
				padding: 0 10px 0 0;
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
		<footer style="position: fixed; right: 0; left: 0; margin-top: 530px; height: 2200px; width: 100%;">
			<div style="display: table;">
				<thead style="width: 100%; border: solid black 1px;">
					<th style="font-size: 10px;  width: 72px; height: 1802px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 14px;  width: 67px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 14px;  width: 492px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; padding-right: 10px;"></th>
					<th style="font-size: 14px;  width: 401px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; padding-right: 10px; padding-left: 10px;"></th>
					<th style="font-size: 14px;  width: 75px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 14px;  width: 210px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 12px;  width: 75px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 12px;  width: 211px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
					<th style="font-size: 12px;  width: 209px; border: solid black 2px; border-top: none; border-right: none; border-bottom: none;"></th>
				</thead>
				<tfoot style="top: 0; bottom: 50; width: 100%;">

                    {{-- TOTAL --}}
                    {{-- <tr class="grand-total">
                        <td class="tdHeight" colspan="2" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none;"></td>
                        <td class="tdHeight" colspan="3" style="text-align: left;  font-size: 18pt; border: solid black 2px; border-top: none; font-weight: bold; border-right: none;"><p class="pHeight" style="margin-left: 10px; border-right: none;"> TOTAL </p></td>
                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; font-weight: bold; "><p class="pHeight" style="margin-right: 10px;">  2,228340.00 </p></td>
                        <td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; font-weight: bold;"> </td>
                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; font-weight: bold;"><p class="pHeight" style="margin-right: 10px;">  2,270,388.00 </p></td>
                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; font-weight: bold; "><p class="pHeight" style="">  42,048.00 </p></td>
                    </tr> --}}
                    <tr>
						<td colspan="9" style="font-size: 16pt; height: 50px;">

						</td>
					</tr>
					<tr>
                        <td colspan="4" style="font-size: 16pt;">
                            Prepared by:
                        </td>
                        <td colspan="5" style="font-size: 16pt;">
                            Reviewed by:
                        </td>
					</tr>
                    <tr>
						<td colspan="9" style="font-size: 16pt; height: 50px;">

						</td>
					</tr>
                    <tr>
                        <td colspan="2">
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
                        <td colspan="2">
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
                        <td colspan="4">
                        </td>
                        <td colspan="5" style="font-size: 16pt;">
                            Approved by:
                        </td>
					</tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="4" style="font-size: 16pt; font-weight: bold; text-align: center;">
                            YVONNE R. CAGAS
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        </td>
                        <td colspan="4" style="font-size: 16pt; text-align: center;">
                            Provincial Governor
                        </td>
                    </tr>
					<tr>
						<td colspan="9" style="font-size: 14px; height: 70px;">

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
			<div>
				<div style="height: 1000px; width: 100%;">
					<table class="tableM" style=" margin-bottom: 401px; height: 200px; top: 0; width: 100%;">
                        <thead style="width: 100%;">
                        <th colspan="9">
                            <p style="font-size: 18px; text-align: right;">Local Budget Preparation From No. 153</p>
                            <p style="font-size: 18px; text-align: right; color: white;">Page 1</p>
                        </th>
                        </thead>
                        <thead>
                        <th colspan="9">
                            <h1>PERSONNEL SCHEDULE</h1>
                        </th>
                        </thead>
                        <thead>
                            <th colspan="2" style="text-align: left; font-size: 18pt; font-weight: normal;">
                                Office/Department
                                <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                            </th>
                            <th colspan="7" style="text-align: left; font-weight: normal; font-size: 18pt;">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ @$department->title }}
                            </th>
                        </thead><thead>
                            <th colspan="2" style="text-align: left; font-size:  18pt; font-weight: normal;">
                                Function
                                <span style="float: right; font-weight: normal; font-size:  18pt;"></span>
                            </th>
                            <th colspan="7" style="text-align: left; font-weight: normal; font-size:  18pt;">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ @$department->function }}
                            </th>
                        </thead>
                        <thead>
                            <th colspan="2" style="text-align: left; font-size:  18pt; font-weight: normal;">
                                Project/Activity
                                <span style="float: right; font-weight: normal; font-size: 18pt;"></span>
                            </th>
                            <th colspan="7" style="text-align: left; font-weight: normal; font-size:  18pt;">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ @$department->projectactivity }}
                            </th>
                        </thead>
                        <thead style="margin-bottom: 20px;">
                            <th colspan="2" style="text-align: left; font-size: 18pt; font-weight: normal;">
                               Fund
                                <span style="float: right; font-weight: normal; font-size: 16px;"></span>
                            </th>
                            <th colspan="7" style="text-align: left; font-weight: normal; font-size:  18pt; ">
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;{{ @$department->fund }}
                            </th>
                        </thead>
                        <thead>
                            <td colspan="9" style="height: 20px;"></td>
                        </thead>
						<thead style=" width: 100%;">
							<th colspan="2" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;"> Ordinance No./ <br> Item No. </th>
                            <th colspan="1" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;"></th>
                            <th colspan="1" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;"></th>
                            <th colspan="2" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-right: none;">Authorized Rate</th>
							<th colspan="2" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; ">Budget Year</th>
                            <th colspan="1" style="font-size: 14pt; font-weight: normal; text-align: center; border: solid black 2px; border-bottom: none; border-left: none; ">Inc./Dec.</th>
						</thead>
						<thead style="width: 100%;">
							<th colspan="2" class="th2" style="font-size: 14pt; font-weight: normal; text-align: left; border-top: none; border-bottom: none; border-right: none;"></th>
							<th colspan="1" style="font-size: 14pt; font-weight: normal; border: solid black 2px;  border-right: none; border-top: none; border-bottom: none;"> Title of Position</th>
                            <th colspan="1" style="font-size: 14pt; font-weight: normal; border: solid black 2px;  border-top: none; border-bottom: none; border-right: none;"> Name of Incumbent</th>
                            <th colspan="2" style="font-size: 14pt; font-weight: normal; border: solid black 2px;  border-right: none; border-top: none; line-height: 2.7rem;"> Per Annum {{ @$previous_plantilla->year }}</th>
                            <th colspan="2" style="font-size: 14pt; font-weight: normal; border: solid black 2px;  border-top: none;"> Rate/Annum {{ @$plantilla->year }}</th>
                            <th colspan="1" style="font-size: 14pt; font-weight: normal; border: solid black 2px;  border-left: none; border-top: none;"></th>
						</thead>
						<thead style="width: 100%;">
							<th style="font-size: 14pt; font-weight: normal; height: 20px; width: 50px; border: solid black 2px; border-top: none; border-right: none;"> Old</th>
							<th style="font-size: 14pt; font-weight: normal;  width: 50px;  border: solid black 2px; border-top: none; border-right: none; border-left: none;"> New</th>
							<th style="font-size: 14pt; font-weight: normal; width: 360px; border: solid black 2px; border-top: none; border-right: none;"> </th>
							<th style="font-size: 14pt; font-weight: normal; width: 300px; border: solid black 2px; border-top: none; border-right: none;"> </th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"> Grade <br> /Step</th>
							<th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; border-right: none;"> Amount</th>
							<th style="font-size: 14pt; font-weight: normal; width: 50px; border: solid black 2px; border-top: none; border-right: none;"> Grade <br> /Step</th>
							<th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-top: none; "> Amount</th>
							<th style="font-size: 14pt; font-weight: normal; width: 150px; border: solid black 2px; border-left: none; border-top: none; "> Amount</th>
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
                            <?php
                                $grand_total_auth = 0;
                                $grand_total_prop = 0;
                                $grand_total_diff = 0;

                                $total_auth = 0;
                                $total_prop = 0;
                                $total_diff = 0;
                            ?>
                            @foreach ($plantillacontents as $content)
                            <tr>
								<td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight">{{ @$content->old_number }}</p> </td>
								<td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight">{{ @$content->new_number }}</p></td>
								<td class="tdHeight" style="text-align: left;  font-size: 18pt; border: solid black 2px;  border-top: none; border-right: none; border-bottom: none; border-left: none; padding-right: 10px;"><p class="pHeight" style="margin-left: 10px;">{{ @$content->position->title }}</p></td>
								<td class="tdHeight" style="text-align: left; font-style: italic; font-weight:bold; font-size: 18pt; border-top: none; border-right: none; border-bottom: none; border-left: none; padding-right: 10px;">
                                    <p class="pHeight" style="margin-left: 10px;">
                                      {!! $content->personalinformation ? $content->personalinformation->firstname . ' ' . @$content->personalinformation->middlename[0] . '. ' . $content->personalinformation->surname . ($content->personalinformation->nameextension ? ', '.$content->personalinformation->nameextension : '') : 'VACANT' !!}
                                    </p>
                                </td>
								<td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;">
                                    <p class="pHeight">
                                        {!! $content->salaryauthorized ? $content->salaryauthorized->grade.'/'.$content->salaryauthorized->step : '' !!}
                                    </p>
                                </td>
								<td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;">
                                    <p class="pHeight" style="margin-right: 10px;">
                                        {!! $content->salaryauthorized ? number_format($content->salaryauthorized->amount * 12) : '' !!}
                                    </p>
                                </td>
								<td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight">{!! $content->salaryproposed ? $content->salaryproposed->grade.'/'.$content->salaryproposed->step : '' !!}</p></td>
								<td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight" style="margin-right: 10px;">{!! $content->salaryproposed ? number_format($content->salaryproposed->amount * 12) : '' !!}</p></td>
                                <?php $diff = $content->salaryproposed ? (($content->salaryproposed->amount * 12) - ($content->salaryauthorized ? $content->salaryauthorized->amount * 12 : 0)) : 0; ?>
                                @if ($diff == 0)
                                <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight" style="margin-right: 10px;">-</p></td>
                                @else
								<td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-right: none; border-bottom: none; border-left: none;"><p class="pHeight" style="margin-right: 10px;">{!! $diff < 0 ? '('.number_format($diff * -1).')' : number_format($diff) !!}</p></td>
                                @endif
							</tr>
                                <?php
                                    $grand_total_auth += $content->salaryauthorized ? $content->salaryauthorized->amount * 12 : 0;
                                    $grand_total_prop += $content->salaryproposed ? $content->salaryproposed->amount * 12 : 0;
                                    $grand_total_diff += $diff;

                                    $total_auth += $content->salaryauthorized ? $content->salaryauthorized->amount * 12 : 0;
                                    $total_prop += $content->salaryproposed ? $content->salaryproposed->amount * 12 : 0;
                                    $total_diff += $diff;
                                ?>
                                @if (fmod($loop->index + 1, 24) == 0)
                                    <tr style="page-break-after: always !important;">
                                        <td class="tdHeight" colspan="2" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none;"></td>
                                        <td class="tdHeight" colspan="3" style="text-align: left;  font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: normal; border-left: none; border-right: none;"></td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: normal; border-left: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_auth < 0 ? '('.number_format($total_auth * -1).')' : number_format($total_auth) !!}</i>  </p> </td>
                                        <td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: bold; border-right: none;"> </td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: normal; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_prop < 0 ? '('.number_format($total_prop * -1).')' : number_format($total_prop) !!}</i>  </p></td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: normal; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_diff < 0 ? '('.number_format($total_diff * -1).')' : number_format($total_diff) !!}</i>  </p></td>
                                    </tr>
                                    <?php
                                        $total_auth = 0;
                                        $total_prop = 0;
                                        $total_diff = 0;
                                    ?>
                                @endif
                                @if ($loop->last)
                                    <tr>
                                        <td class="tdHeight" colspan="2" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none;"></td>
                                        <td class="tdHeight" colspan="3" style="text-align: left;  font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: normal; border-left: none; border-right: none;"></td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: normal; border-left: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_auth < 0 ? '('.number_format($total_auth * -1).')' : number_format($total_auth) !!}</i>  </p> </td>
                                        <td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: bold; border-right: none;"> </td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: normal; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_prop < 0 ? '('.number_format($total_prop * -1).')' : number_format($total_prop) !!}</i>  </p></td>
                                        <td class="tdHeight" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: normal; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;"> <i>{!! $total_diff < 0 ? '('.number_format($total_diff * -1).')' : number_format($total_diff) !!}</i>  </p></td>
                                    </tr>
                                    <tr style="page-break-after: always !important;">
                                        <td class="tdHeight" colspan="2" style="text-align: right; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none;"></td>
                                        <td class="tdHeight" colspan="3" style="text-align: left;  font-size: 20pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: bold; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;margin-left: 10px;">TOTAL</p> </td>
                                        <td class="tdHeight" style="text-align: right; font-size: 20pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: bold; border-left: none;"><p class="pHeight" style="margin-right: 10px;"> {!! $grand_total_auth < 0 ? '('.number_format($grand_total_auth * -1).')' : number_format($grand_total_auth) !!}  </p> </td>
                                        <td class="tdHeight" style="text-align: center; font-size: 18pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: bold; border-right: none;"> </td>
                                        <td class="tdHeight" style="text-align: right; font-size: 20pt; border: solid black 2px; border-top: none; border-bottom: none; border-right: none; font-weight: bold; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;"> {!! $total_prop < 0 ? '('.number_format($grand_total_prop * -1).')' : number_format($grand_total_prop) !!}  </p></td>
                                        <td class="tdHeight" style="text-align: right; font-size: 20pt; border: solid black 2px; border-top: none; border-bottom: none; font-weight: bold; border-left: none; border-right: none;"><p class="pHeight" style="margin-right: 10px;">{!! $grand_total_diff < 0 ? '('.number_format($grand_total_diff * -1).')' : number_format($grand_total_diff) !!}  </p></td>
                                    </tr>
                                @endif

                            @endforeach
						</tbody>

					</table>

				</div>

			</div>

		</main>
		<script type="text/php">

        </script>
	</body>

</html>
