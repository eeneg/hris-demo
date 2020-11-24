@foreach($trainingPrograms_cont->chunk(42) as $chunks)
<div class="page-break" id="page3-div" style="position:relative;width:918px;height:1404px; margin-top: 20px;">
    @include('reports.pds_images.trainingProgBackground')

    <p style="position:absolute;top:28px;left:26px;white-space:nowrap" class="ft14"><i><b>VII.&#160;&#160;LEARNING&#160;AND&#160;DEVELOPMENT&#160;(L&amp;D)&#160;INTERVENTIONS/TRAINING&#160;PROGRAMS&#160;ATTENDED</b></i></p>
    <p style="position:absolute;top:70px;left:31px;white-space:nowrap" class="ft11">30.</p>
    <p style="position:absolute;top:70px;left:55px;white-space:nowrap;font-size: 8px;" class="ft11">TITLE OF&#160;LEARNING&#160;AND&#160;DEVELOPMENT&#160;INTERVENTIONS/TRAINING&#160;PROGRAMS &#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;</p>
    <p style="position:absolute;top:85px;left:194px;white-space:nowrap;font-size: 8px" class="ft11">(Write&#160;in&#160;full)</p>
    <p style="position:absolute;top:55px;left:420px;white-space:nowrap" class="ft11">INCLUSIVE DATES OF&#160;</p>
    <p style="position:absolute;top:68px;left:440px;white-space:nowrap" class="ft11">ATTENDANCE &#160;&#160;&#160;</p>
    <p style="position:absolute;top:81px;left:442px;white-space:nowrap" class="ft11">(mm/dd/yyyy)</p>
    <p style="position:absolute;top:100px;left:429px;white-space:nowrap" class="ft11">From</p>
    <p style="position:absolute;top:100px;left:501px;white-space:nowrap" class="ft11">To</p>
    <p style="position:absolute;top:80px;left:540px;white-space:nowrap" class="ft10">NUMBER&#160;OF&#160;HOURS</p>
    <p style="position:absolute;top:60px;left:625px;white-space:nowrap" class="ft10">Type&#160;of&#160;LD</p>
    <p style="position:absolute;top:70px;left:622px;white-space:nowrap" class="ft10">&#160;(&#160;Managerial/&#160;</p>
    <p style="position:absolute;top:80px;left:623px;white-space:nowrap" class="ft10">Supervisory/</p>
    <p style="position:absolute;top:90px;left:621px;white-space:nowrap" class="ft10">Technical/etc)&#160;</p>
    <p style="position:absolute;top:70px;left:718px;white-space:nowrap" class="ft11">&#160;CONDUCTED/&#160;SPONSORED&#160;BY &#160;&#160;</p>
    <p style="position:absolute;top:85px;left:758px;white-space:nowrap" class="ft11">(Write&#160;in&#160;full)</p>

    <table style="width:887px;position:absolute;top:113px;left:17px; border-collapse:separate;border-spacing:0px;table-layout: fixed; text-align:center;">
        <tr>
            <th style="width: 39%;"></th>
            <th style="width: 7%;"></th>
            <th style="width: 7%;"></th>
            <th style="width: 7%;"></th>
            <th style="width: 7%;"></th>
            <th style="width: 23%;"></th>
        </tr>
        <tbody>
            @foreach ($chunks as $trainingprogram)
            <tr>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs">{{@$trainingprogram->title}}</p></td>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs">{{ @$trainingprogram->inclusiveDateFrom }}</p></td>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs">{{ @$trainingprogram->inclusiveDateTo }}</p></td>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs">{{@$trainingprogram->hours}}</p></td>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs"></p></td>
                <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="c-inputs">{{@$trainingprogram->conductor}}</p></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="position:absolute;top:1348px;left:104px;white-space:nowrap" class="ft112"><i><b>SIGNATURE</b></i></p>
    <p style="position:absolute;top:1348px;left:593px;white-space:nowrap" class="ft112"><i><b>DATE</b></i></p>
    <p style="position:absolute;top:1340px;left:386px;white-space:nowrap" class="ft15"><i><b>(Continue&#160;on&#160;separate&#160;sheet&#160;if&#160;necessary)</b></i></p>
    {{-- <p style="position:absolute;top:1346px;left:725px;white-space:nowrap" class="ft11"><i>CS&#160;FORM&#160;212&#160;(Revised&#160;2017),&#160;Page&#160;3&#160;of&#160;4</i></p> --}}
</div>
@endforeach
