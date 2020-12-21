@foreach($workExperiences_cont->chunk(39) as $chunks)
<div class="page-break" id="workexcont-div" style="position:relative;width:918px;height:1404px; margin-top: 20px;">
    @include('reports.pds_images.workExBackground')
    {{-- Work Ex --}}
        <p style="position:absolute;top:23px;left:22px;white-space:nowrap" class="ft14"><i><b>V.&#160;&#160;WORK&#160;EXPERIENCE</b></i></p>
        <p style="position:absolute;top:40px;left:22px;white-space:nowrap" class="ft11"><i><b>(Include&#160;private&#160;employment.&#160;&#160;Start&#160;from&#160;your&#160;recent&#160;work)&#160;Description&#160;of&#160;duties&#160;should&#160;be&#160;indicated&#160;in&#160;the&#160;attached&#160;Work&#160;Experience&#160;sheet.)</b></i></p>
        <p style="position:absolute;top:68px;left:21px;white-space:nowrap" class="ft11">28.</p>
        <p style="position:absolute;top:68px;left:50px;white-space:nowrap" class="ft11">INCLUSIVE&#160;DATES</p>
        <p style="position:absolute;top:80px;left:63px;white-space:nowrap" class="ft11">(mm/dd/yyyy)</p>
        <p style="position:absolute;top:108px;left:40px;white-space:nowrap" class="ft11">From</p>
        <p style="position:absolute;top:108px;left:120px;white-space:nowrap" class="ft11">To</p>
        <p style="position:absolute;top:80px;left:235px;white-space:nowrap" class="ft11">POSITION&#160;TITLE</p>
        <p style="position:absolute;top:95px;left:205px;white-space:nowrap" class="ft11">(Write&#160;in&#160;full/Do&#160;not&#160;abbreviate)</p>
        <p style="position:absolute;top:80px;left:405px;white-space:nowrap" class="ft11">DEPARTMENT&#160;/&#160;AGENCY&#160;/&#160;OFFICE&#160;/&#160;COMPANY</p>
        <p style="position:absolute;top:95px;left:445px;white-space:nowrap" class="ft11">(Write&#160;in&#160;full/Do&#160;not&#160;abbreviate)</p>
        <p style="position:absolute;top:80px;left:634px;white-space:nowrap" class="ft11">MONTHLY&#160;</p>
        <p style="position:absolute;top:95px;left:637px;white-space:nowrap" class="ft11">SALARY</p>
        <p style="position:absolute;top:70px;left:694px;white-space:nowrap" class="ft10">SALARY/&#160;JOB/&#160;PAY</p>
        <p style="position:absolute;top:80px;left:709px;white-space:nowrap" class="ft10">GRADE&#160;(if&#160;</p>
        <p style="position:absolute;top:90px;left:698px;white-space:nowrap" class="ft10">applicable)&#160;STEP</p>
        <p style="position:absolute;top:100px;left:700px;white-space:nowrap" class="ft10">(Format&#160;&#34;00-0&#34;)/&#160;</p>
        <p style="position:absolute;top:110px;left:705px;white-space:nowrap" class="ft10">INCREMENT</p>
        <p style="position:absolute;top:80px;left:775px;white-space:nowrap" class="ft11">STATUS OF&#160;</p>
        <p style="position:absolute;top:95px;left:768px;white-space:nowrap" class="ft11">APPOINTMENT</p>
        <p style="position:absolute;top:70px;left:856px;white-space:nowrap" class="ft11">GOV'T&#160;</p>
        <p style="position:absolute;top:85px;left:850px;white-space:nowrap" class="ft11">SERVICE &#160;&#160;</p>
        <p style="position:absolute;top:100px;left:858px;white-space:nowrap" class="ft11">(Y/&#160;N)</p>

    <table id="we-tbl" style="width:882px;position:absolute;top:120px;left:19px; border-collapse:separate;border-spacing:0px;table-layout: fixed;text-align:center;">
        <tbody>
            <tr>
                <th class="" style="width: 6%;"></th>
                <th class="" style="width: 6%;"></th>
                <th class="" style="width: 19%;"></th>
                <th class="" style="width: 20%;"></th>
                <th class="" style="width: 5%;"></th>
                <th class="" style="width: 6%;"></th>
                <th class="" style="width: 7%;"></th>
                <th class="" style="width: 5%;"></th>
            </tr>
            @foreach ($chunks as $workexperience)
            <tr>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->inclusiveDateFrom }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->inclusiveDateTo }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->position }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->department }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->monthlySalary }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->salaryGrade }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->statusOfAppointment }}
                    </p>
                </td>
                <td style="border-collapse:collapse;height:29px;border-spacing:0;">
                    <p class="inputs">
                        {{ @$workexperience->govService }}
                    </p>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="position:absolute;top:1353px;left:55px;white-space:nowrap" class="ft112"><i><b>SIGNATURE</b></i></p>
    <p style="position:absolute;top:1353px;left:543px;white-space:nowrap" class="ft112"><i><b>DATE</b></i></p>
    <p style="position:absolute;top:1330px;left:373px;white-space:nowrap" class="ft15"><i><b>(Continue&#160;on&#160;separate&#160;sheet&#160;if&#160;necessary)</b></i></p>
</div>
@endforeach
