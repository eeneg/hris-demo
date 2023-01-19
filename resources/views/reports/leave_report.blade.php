<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>

	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
	<title></title>
	<style type="text/css">
		body,div,table,thead,tbody,tfoot,tr,th,td,p {
            font-family:"Helvetica"; font-size:x-small;
            padding: 0%;
        }

        /* tr, td{
            border: 1px solid #000000;
        } */
        @page { margin-left: 0px; }
        body { margin-left: 0px; }
	</style>

</head>

<body>
    <div class="page-break" id="1" style="margin-left: 55px !important; padding: 0;">
        <div>
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
                    <td colspan="3" rowspan="6" height="21" align="center" valign=middle>
                        <b><font face="Helvetica" size=3 color="#000000">
                        @include('reports.leave_report_logo.leave-report-logo')
                    </td>
                    <td colspan=10 height="20" align="center" style="text-align: center;" valign=bottom><font face="Helvetica" color="#000000">Republic of the Philippines</font></td>
                </tr>
                <tr>
                    <td colspan=10 height="21" align="center" valign=bottom><b><font face="Helvetica" size=3 color="#000000">PROVINCE OF DAVAO DEL SUR</font></b></td>
                    <td colspan=4 rowspan="5" height="21" align="center" valign=bottom><b><font face="Helvetica" size=3 color="#000000"></font></b></td>
                </tr>
                <tr>
                    <td colspan=10 height="20" align="center" valign=middle><font face="Helvetica" color="#000000">Matti, Digos City</font></td>
                </tr>
                <tr>
                    <td colspan=10 height="25" align="center" valign=bottom><b><font face="Helvetica" size=4 color="#000000">PROVINCIAL HUMAN RESOURCE MANAGEMENT OFFICE</font></b></td>
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
                    <td style="border: 1px solid #000000;" rowspan=4 align="center" bgcolor="#7F7F7F">
                        <b>B</b> <br>
                        <b>A</b> <br>
                        <b>S</b> <br>
                        <b>I</b> <br>
                        <b>S</b>
                    </td>
                    <td style="border-top: 1px solid #000000; border-right: 1px solid #000000; max-height: 5px" colspan=15 align="left" valign=middle bgcolor="#F2F2F2">
                        <i style="margin-left: 10px; max-height: 5px">
                            Tardiness: ten (10) times a month for at least two (2) months in a semester / at least two (2) consecutive months during the year
                        </i>
                    </td>
                    <td align="left" valign=middle style="max-height: 5px"><br></td>
                </tr>
                <tr>

                    <td style="border-right: 1px solid #000000; max-height: 5px" colspan=15 align="left" valign=middle bgcolor="#F2F2F2">
                        <i style="margin-left: 10px; max-height: 5px">
                            Undertime: ten (10) times a month for at least two (2) months in a semester / at least two (2) consecutive months during the year
                        </i>
                    </td>
                    <td align="left" valign=middle style="max-height: 5px"> <br></td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000000; max-height: 5px" colspan=15 align="left" valign=middle bgcolor="#F2F2F2">
                        <i style="margin-left: 10px; max-height: 5px">
                            Habitual Absenteeism: unauthorized absences exceeding allowable 2.5 days monthly leave credit for at least three (3) months in a semester / at least three (3) consecutive months during the year
                        </i>
                    </td>
                    <td align="left" valign=middle style="max-height: 5px"><br></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #000000;border-right: 1px solid #000000; max-height: 5px"  colspan=15 align="left" valign=middle bgcolor="#F2F2F2">
                        <i style="margin-left: 10px; max-height: 5px">(CSC MC No. 16, S. 2010; CSC MC No. 01, S. 2017)</i>
                    </td>
                    <td align="left" valign=middle style="max-height: 5px"><i><br></i></td>
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
                    <td style="border: 1px solid #000000;" colspan=15  align="center" valign=middle bgcolor="#FFB3B5"><b><font color="#000000">{{ Carbon\Carbon::create()->month($d['month'])->format('F') }} </font></b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle bgcolor="#FFB3B5"><b><font color="#000000">Tardiness</font></b></td>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle bgcolor="#DAFEE2"><b><font color="#000000">Undertime</font></b></td>
                    <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle bgcolor="#ABD5FF"><b><font color="#000000">Absence</font></b></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle bgcolor="#FFB3B5"><font color="#000000">Frequency</font></td>
                    <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle bgcolor="#FFB3B5"><font color="#000000">Length of Time</font></td>
                    <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle bgcolor="#DAFEE2"><font color="#000000">Frequency</font></td>
                    <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle bgcolor="#DAFEE2"><font color="#000000">Length of Time</font></td>
                    <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle bgcolor="#ABD5FF"><font color="#000000">Unauthorized Absence</font></td>
                    <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle bgcolor="#ABD5FF"><font color="#000000">Absent Without Leave</font></td>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($d['records'] as $key => $data)
                    <tr>
                        <td style="border: 1px solid #000000; text-align: center;" align="left" valign=middle>
                            @php
                                echo $i++;
                            @endphp
                        </td>
                        <td style="border: 1px solid #000000;" align="left" valign=middle>
                            <font color="#000000">
                                <P style="margin-left: 10px; margin-right: 10px;">
                                    {{ $key }}
                                </P>
                        </td>
                        <td style="border: 1px solid #000000;" align="center" valign=middle>
                            {{ @$data['office'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle>
                            {{ @$data['Tardy']['count'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle>
                            {{ @$data['Tardy']['mins'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle>
                            {{ @$data['Undertime']['count'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle>
                            {{ @$data['Undertime']['mins'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=2 align="center" valign=middle>
                            {{ @$data['UA']['count'] }}
                        </td>
                        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle>
                            {{ @$data['AWOL']['count'] }}
                            </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <br clear=left>
    </div>
    <div class="" id="2" style="width: 1315px; margin-left: 60px; page-break-inside: avoid;">
        <table style="display:inline-table; width: 1300px; margin-left: 50px;" valign=top>
            <thead>
                    <tr>
                        <th style="width: 150px;"></th>
                        <th style="width: 150px;"></th>
                        <th style="width: 150px;"></th>
                        <th style="width: 150px;"></th>
                        <th style="width: 150px;"></th>
                    </tr>
            </thead>
            <tbody>
                    <tr>
                        <td style="height: 50px;">
                            <h1>Prepared By:</h1>
                        </td>
                        <td style="height: 50px;"></td>
                        <td style="height: 50px;"></td>
                        <td style="height: 50px;"></td>
                        <td style="height: 50px;">
                            <h1>Noted By:</h1>
                        </td>
                    </tr>
                <tr>
                    <td style="padding: 0%; text-align: center; height: 50px;">
                        <h3 style="margin: 0px; padding: 0%;"> {{ @$d['prep'][0]['name'] }}</h3>
                        <h4 style="margin: 0%; padding: 0%;"> {{ @$d['prep'][0]['position'] }}</h4>
                    </td>
                    <td style="padding: 0%; text-align: center; height: 50px;">
                        <h3 style="margin: 0px; padding: 0%;"> {{ @$d['prep'][1]['name'] }}</h3>
                        <h4 style="margin: 0%; padding: 0%;"> {{ @$d['prep'][1]['position'] }}</h4>
                    </td>
                    <td style="padding: 0%; text-align: center; height: 50px;">
                        <h3 style="margin: 0px; padding: 0%;">{{ @$d['prep'][2]['name'] }}</h3>
                        <h4 style="margin: 0%; padding: 0%;">{{ @$d['prep'][2]['position'] }}</h4>
                    </td>
                    <td></td>
                    <td style="padding: 0%; text-align: center; height: 50px;">
                        <h3 style="margin: 0px; padding: 0%;">{{$d['noted']['name']}}</h3>
                        <h4 style="margin: 0px; padding: 0%;">{{$d['noted']['position']}}</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
