<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title></title>
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p {
            font-family:"Calibri"; font-size:x-small
        }

        /* tr, td{
            border: 1px solid #000000;
        } */
	</style>

</head>

<body>
    <div class="container" style="">
        <div class="page-break" style="position: relative; margin-left: 90px !important; padding: 0;">
            <table align="left" cellspacing="0" border="0">
                <colgroup width="42"></colgroup>
                <colgroup width="180"></colgroup>
                <colgroup width="84"></colgroup>
                <colgroup width="64"></colgroup>
                <colgroup span="3" width="68"></colgroup>
                <colgroup width="54"></colgroup>
                <colgroup width="64"></colgroup>
                <colgroup width="68"></colgroup>
                <colgroup span="2" width="64"></colgroup>
                <colgroup width="68"></colgroup>
                <colgroup span="3" width="64"></colgroup>
                <colgroup width="68"></colgroup>
                <tr>
                    <td colspan="3" rowspan="6" height="21" align="center" valign=bottom><b><font face="Times New Roman" size=3 color="#000000">
                        @include('reports.leave_report_logo.leave-report-logo')
                    </td>
                    <td colspan=10 height="20" align="center" style="text-align: center;" valign=bottom><font face="Times New Roman" color="#000000">Republic of the Philippines</font></td>
                </tr>
                <tr>
                    <td colspan=10 height="21" align="center" valign=bottom><b><font face="Times New Roman" size=3 color="#000000">PROVINCE OF DAVAO DEL SUR</font></b></td>
                    <td colspan=4 rowspan="5" height="21" align="center" valign=bottom><b><font face="Times New Roman" size=3 color="#000000"></font></b></td>
                </tr>
                <tr>
                    <td colspan=10 height="20" align="center" valign=middle><font face="Times New Roman" color="#000000">Matti, Digos City</font></td>
                </tr>
                <tr>
                    <td colspan=10 height="25" align="center" valign=bottom><b><font face="Times New Roman" size=4 color="#000000">PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</font></b></td>
                </tr>
                <tr>
                    <td colspan=10 height="28" align="center" valign=middle><b><font size=4 color="#000000">ATTENDANCE REPORT </font></b></td>
                </tr>
                <tr>
                    <td colspan=10 height="20" align="center" valign=middle><b><font color="#000000">
                        {{ Carbon\Carbon::create()->month($d['month'])->format('F') }} {{ $d['year'] }}</font></b>
                    </td>
                </tr>
                <tr>
                    <td height="20" align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" rowspan=4 height="84" align="center" bgcolor="#7F7F7F">
                        <b>B</b> <br>
                        <b>A</b> <br>
                        <b>S</b> <br>
                        <b>I</b> <br>
                        <b>S</b>
                    </td>
                    <td style="border-top: 1px solid #000000; border-right: 1px solid #000000;" colspan=15 align="left" valign=top bgcolor="#F2F2F2">
                        Tardiness: ten (10) times a month for at least two (2) months in a semester / at least two (2) consecutive months during the year
                    </td>
                    <td align="left" valign=top><br></td>
                </tr>
                <tr>

                    <td style="border-right: 1px solid #000000;" colspan=15 align="left" valign=top bgcolor="#F2F2F2">
                        Undertime: ten (10) times a month for at least two (2) months in a semester / at least two (2) consecutive months during the year
                    </td>
                    <td align="left" valign=top><br></td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000000;" colspan=15 align="left" valign=top bgcolor="#F2F2F2">
                        Habitual Absenteeism: unauthorized absences exceeding allowable 2.5 days monthly leave credit for at least three (3) months in a semester / at least three (3) consecutive months during the year
                    </td>
                    <td align="left" valign=top><br></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000;"  colspan=15 align="left" valign=top bgcolor="#F2F2F2">
                        <i>(CSC MC No. 16, S. 2010; CSC MC No. 01, S. 2017)</i>
                    </td>
                    <td align="left" valign=top><i><br></i></td>
                </tr>
                <tr>
                    <td height="21" align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                    <td align="left" valign=bottom><font color="#000000"><br></font></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" rowspan=3 height="75" align="center" valign=middle><b><font color="#000000">No.</font></b></td>
                    <td style="border: 1px solid #000000;" rowspan=3 align="center" valign=middle><b><font color="#000000">Name</font></b></td>
                    <td style="border: 1px solid #000000;" rowspan=3 align="center" valign=middle><b><font color="#000000">Office</font></b></td>
                    <td style="border: 1px solid #000000;" colspan=15  align="center" valign=top bgcolor="#FFB3B5"><b><font color="#000000">{{ Carbon\Carbon::create()->month($d['month'])->format('F') }} </font></b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=top bgcolor="#FFB3B5"><b><font color="#000000">Tardiness</font></b></td>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=top bgcolor="#DAFEE2"><b><font color="#000000">Undertime</font></b></td>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=top bgcolor="#ABD5FF"><b><font color="#000000">Abscense</font></b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" colspan=3 align="center" valign=top bgcolor="#FFB3B5"><font color="#000000">Frequency</font></td>
                    <td style="border: 1px solid #000000;" colspan=2 align="center" valign=top bgcolor="#FFB3B5"><font color="#000000">Length of Time</font></td>
                    <td style="border: 1px solid #000000;" colspan=3 align="center" valign=top bgcolor="#DAFEE2"><font color="#000000">Frequency</font></td>
                    <td style="border: 1px solid #000000;" colspan=2 align="center" valign=top bgcolor="#DAFEE2"><font color="#000000">Length of Time</font></td>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=top bgcolor="#ABD5FF"><font color="#000000">Number of Days</font></td>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($d['records'] as $key => $data)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: center;" height="20" align="left" valign=top>
                            @php
                                echo $i++;
                            @endphp
                        </td>
                        <td style="border: 1px solid #000000;" align="left" valign=top>
                            <font color="#000000">
                            {{ $key }}
                        </td>
                        <td style="border: 1px solid #000000;" align="left" valign=top>
                        </td>
                        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=top>
                           {{ @$data['Tardy']['count'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=2 align="center" valign=top>
                           {{ @$data['Tardy']['mins'] }} minutes
                        </td>
                        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=top>
                           {{ @$data['Undertime']['count'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=2 align="center" valign=top>
                            {{ @$data['Undertime']['mins'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=top>
                           {{ @$data['UA']['count'] }}
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td style="text-align: center;" height="20" align="left" valign=top>

                        </td>
                        <td style="" align="left" valign=top>
                            <font color="#000000">
                        </td>
                        <td style="" align="left" valign=top>

                        </td>
                        <td style="" colspan=3 align="center" valign=top>

                        </td>
                        <td style="" colspan=2 align="center" valign=top>

                        </td>
                        <td style="" colspan=3 align="center" valign=top>

                        </td>
                        <td style="" colspan=2 align="center" valign=top>

                        </td>
                        <td style="" colspan=5 align="center" valign=top>

                        </td>
                    </tr>
            </table>
            {{-- <img src="result_htm_bb54089728bbfb65.jpg" width=147 height=147> --}}
            <br clear=left>
            <div style="width: 1215px;">
                <table style="display:inline-table; width: 604px;">
                    <thead>
                         <tr>
                            <th style="width: 50%"></th>
                            <th style="width: 30%"></th>
                            <th style="width: 30%"></th>
                         </tr>
                    </thead>
                    <tbody>
                         <tr>
                             <td>
                                 <h1>Prepared By:</h1>
                             </td>
                             <td></td>
                         </tr>
                         @foreach ($d['prep'] as $prep)
                             <tr>
                                 <td></td>
                                 <td style="padding: 0%; text-align: center; height: 50px;">
                                     <h3 style="margin: 0px; padding: 0%;">{{$prep['name']}}</h3>
                                     <h4 style="margin: 0%; padding: 0%;"> {{$prep['position']}}</h4>
                                 </td>
                                <th></th>
                             </tr>
                         @endforeach
                    </tbody>
                </table>
                <table style="display:inline-table; width: 604px;">
                    <thead>
                         <tr>
                            <th style="width: 50%"></th>
                            <th style="width: 30%"></th>
                            <th style="width: 30%"></th>
                         </tr>
                    </thead>
                    <tbody>
                         <tr>
                             <td>
                                 <h1>Prepared By:</h1>
                             </td>
                             <td></td>
                         </tr>
                        <tr>
                            <td></td>
                            <td style="padding: 0%; text-align: center; height: 50px;">
                                <h3 style="margin: 0px; padding: 0%;">{{$d['noted']['name']}}</h3>
                                <h4 style="margin: 0%; padding: 0%;">{{$d['noted']['position']}}</h4>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- <div style="display: flex;">
                <div style="display:inline-block;width:50%">
                    <div style="display:inline-block;width:10%">

                    </div>
                    <div style="display:inline-block;width:33%; text-align:center; padding:0%; margin: 0%;">
                        @foreach ($d['prep'] as $prep)
                            <h3 style="font-weight: bold; margin-top: 10px; padding: 0%">
                                {{$prep['name']}} <br>
                                {{$prep['position']}}
                            </h3>
                        @endforeach
                    </div>
                    <div style="display:inline-block;width:33%">

                    </div>
                </div>

                <div style="display:inline-block;width:50%">
                    <div class="">
                        <div style="display:inline-block;width:50%">
                            <div style="display:inline-block;width:10%">

                            </div>
                            <div style="text-align:center; margin: 0%; padding: 0%">
                                <h3 style="font-weight: bold; margin: 0%; padding: 0%">
                                    {{$d['noted']['name']}} <br>
                                    {{$d['noted']['position']}}
                                </h3>
                            </div>
                            <div style="display:inline-block;width:33%">

                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</body>
</html>
