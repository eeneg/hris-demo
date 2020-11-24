<!DOCTYPE html>
<html>
<head>
<title></title>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
 <br/>
<style type="text/css">
    @page{margin: 0%; padding: 0%;}
	p {margin: 0; padding: 0;}
    .ft10{font-size:6px;font-family: Arial, Helvetica, sans-serif;color:#000000;font-weight:bold;}
	.ft11{font-size:9px;font-family: Arial, Helvetica, sans-serif;color:#000000;}
	.ft13{font-size:10px;font-family: Arial, Helvetica, sans-serif;color:#000000;}
	.ft14{font-size:12px;font-family: Arial, Helvetica, sans-serif;color:#ffffff;font-weight:bold;}
	.ft15{font-size:7px;font-family: Arial, Helvetica, sans-serif;color:#ff0000;font-weight:bold;}
	.ft19{font-size:11px;font-family: Arial, Helvetica, sans-serif;color:#000000;}
	.ft110{font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight: 800; color :#000000;}
	.ft112{font-size:11px;font-family: Arial, Helvetica, sans-serif;color:#000000;font-weight:bold;}
    .inputs{font-size: 9.5px;font-family: Arial, Helvetica, sans-serif; line-height: 0.9;}
    .f-inputs{font-size: 12px;font-family: Arial, Helvetica, sans-serif; line-height: 12px;}
    .c-inputs{font-size: 9.5px;font-family: Arial, Helvetica, sans-serif; line-height: 0.8;}
    .page-break {page-break-after: always;}
    #educ_back { display:flex; justify-content: center;align-items: center; }
</style>
</head>
<body style="background-color: grey">
    <div class="page-break" id="page1-div" style="position:relative;width:918px;height:1404px;margin: 0; padding: 0;">
        @include('reports.pds_images.page1')
        {{-- HEADER --}}
        <p style="position:absolute;top:26px;left:25px;white-space:nowrap" class="ft112"><i><b>CS Form No. 212</b></i></p>
        <p style="position:absolute;top:39px;left:25px;white-space:nowrap" class="ft11"><i><b>Revised 2017</b></i></p>
        <h1 style="position:absolute;top:30px;left:273px;white-space:nowrap" class="ft110">PERSONAL DATA SHEET</h1>
        <p style="position:absolute;top:97px;left:24px;white-space:nowrap" class="ft13"><i><b>WARNING: Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the  <br> person concerned.</b></i></p>
        <p style="position:absolute;top:120px;left:24px;white-space:nowrap" class="ft13"><i><b>READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.</b></i></p>
        <p style="position:absolute;top:133px;left:24px;white-space:nowrap" class="ft11">Print legibly. Tick appropriate boxes (     ) and use separate sheet if necessary. Indicate N/A if not applicable.  <b>DO NOT ABBREVIATE.</b></p>
        <p style="position:absolute;top:134px;left:638px;white-space:nowrap" class="ft11">1. CS ID No.</p>
        <p style="position:absolute;top:134px;left:753px;white-space:nowrap" class="ft11"> (Do not fill up. For CSC use only)</p>

        {{-- I. PERSONAL INFORMATION --}}
        <p style="position:absolute;top:153px;left:24px;white-space:nowrap" class="ft14">
            <i>
                <b>I. PERSONAL INFORMATION</b>
            </i>
        </p>

        <p style="position:absolute;top:178px;left:31px;white-space:nowrap" class="ft13">
            2. SURNAME
        </p>
        <p style="position:absolute;top:178px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->surname }}
        </p>

        <p style="position:absolute;top:205px;left:41px;white-space:nowrap" class="ft13">
            FIRST NAME
        </p>
        <p style="position:absolute;top:205px;left:202px;white-space:nowrap"class="f-inputs">
            {{ @$personalinfos->firstname }}
        </p>

        <p style="position:absolute;top:200px;left:692px;white-space:nowrap" class="ft11">
            NAME EXTENSION (JR., SR)
        </p>
        <p style="position:absolute;top:210px;left:750px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->nameextension }}
        </p>

        <p style="position:absolute;top:233px;left:41px;white-space:nowrap" class="ft13">
            MIDDLE NAME
        </p>
        <p style="position:absolute;top:233px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->middlename }}
        </p>

        <p style="position:absolute;top:264px;left:30px;white-space:nowrap" class="ft13">
            3. DATE OF BIRTH<br/>    (mm/dd/yyyy)
        </p>
        <p style="position:absolute;top:270px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->birthdate }}
        </p>

        <p style="position:absolute;top:305px;left:30px;white-space:nowrap" class="ft13">
            4. PLACE OF BIRTH
        </p>
        <p style="position:absolute;top:305px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->birthplace }}
        </p>

        <p style="position:absolute;top:337px;left:30px;white-space:nowrap" class="ft13">
            5. SEX
        </p>
        <p style="position:absolute;top:337px;left:202px;white-space:nowrap" class="ft13">
            Male
        </p>
        <p style="position:absolute;top:337px;left:182px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->sex == 'Male' ? 'X' : '' }}
        </p>
        <p style="position:absolute;top:337px;left:327px;white-space:nowrap" class="ft13">
            Female
        </p>
        <p style="position:absolute;top:337px;left:310px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->sex == 'Female' ? 'X' : '' }}
        </p>


        <p style="position:absolute;top:365px;left:30px;white-space:nowrap" class="ft13">
            6. CIVIL STATUS
        </p>
        <p style="position:absolute;top:363px;left:202px;white-space:nowrap" class="ft13">
            Single
        </p>
        <p style="position:absolute;top:363px;left:183px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->civilstatus == 'Single' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:364px;left:327px;white-space:nowrap" class="ft13">
            Married
        </p>
        <p style="position:absolute;top:364px;left:310px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->civilstatus == 'Married' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:381px;left:202px;white-space:nowrap" class="ft13">
            Widowed
        </p>
        <p style="position:absolute;top:381px;left:183px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->civilstatus == 'Widowed' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:382px;left:327px;white-space:nowrap" class="ft13">
            Separated
        </p>
        <p style="position:absolute;top:382px;left:310px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->civilstatus == 'Separated' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:399px;left:202px;white-space:nowrap" class="ft13">
            Other/s:
        </p>
        <p style="position:absolute;top:399px;left:183px; font-weight:bold;" class="f-inputs">
            {{ @$personalinfos->civilstatus == 'Other' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:428px;left:30px;white-space:nowrap" class="ft13">
            7. HEIGHT (m)
        </p>
        <p style="position:absolute;top:428px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->height }}
        </p>

        <p style="position:absolute;top:457px;left:30px;white-space:nowrap" class="ft13">
            8. WEIGHT (kg)
        </p>
        <p style="position:absolute;top:457px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->weight }}
        </p>

        <p style="position:absolute;top:486px;left:30px;white-space:nowrap" class="ft13">
            9. BLOOD TYPE
        </p>
        <p style="position:absolute;top:486px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->bloodtype }}
        </p>

        <p style="position:absolute;top:517px;left:25px;white-space:nowrap" class="ft13">
            10. GSIS ID NO.
        </p>
        <p style="position:absolute;top:517px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->gsis }}
        </p>

        <p style="position:absolute;top:548px;left:25px;white-space:nowrap" class="ft13">
            11. PAG-IBIG ID NO.
        </p>
        <p style="position:absolute;top:548px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->pagibig }}
        </p>

        <p style="position:absolute;top:580px;left:25px;white-space:nowrap" class="ft13">
            12. PHILHEALTH NO.
        </p>
        <p style="position:absolute;top:580px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->philhealth }}
        </p>

        <p style="position:absolute;top:610px;left:25px;white-space:nowrap" class="ft13">
            13. SSS NO.
        </p>
        <p style="position:absolute;top:610px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->sss }}
        </p>

        <p style="position:absolute;top:640px;left:24px;white-space:nowrap" class="ft13">
            14. TIN NO.
        </p>
        <p style="position:absolute;top:640px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->tin }}
        </p>

        <p style="position:absolute;top:671px;left:24px;white-space:nowrap" class="ft13">
            15. AGENCY EMPLOYEE NO.
        </p>
        <p style="position:absolute;top:671px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->agencynumber }}
        </p>

        <p style="position:absolute;top:261px;left:390px;white-space:nowrap" class="ft13">
            16. CITIZENSHIP
        </p>
        <p style="position:absolute;top:305px;left:434px;white-space:nowrap" class="ft13">
            If holder of  dual citizenship,
        </p>
        <p style="position:absolute;top:332px;left:438px;white-space:nowrap" class="ft13">
            please indicate the details.
        </p>

        <p style="position:absolute;top:267px;left:614px;white-space:nowrap" class="ft13">
            Filipino
        </p>
        <p style="position:absolute;top:266px;left:599px;white-space:nowrap" class="inputs">
            {{ @$personalinfos->citizenship == 'Filipino' ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:266px;left:694px;white-space:nowrap" class="ft13">
            Dual Citizenship
        </p>
        <p style="position:absolute;top:266px;left:680px;white-space:nowrap" class="inputs">
            {{ (@$personalinfos->citizenship == 'Dual Citizenship (By Birth)' || @$personalinfos->citizenship == 'Dual Citizenship (By Naturalization)') ? 'X' : '' }}
        </p>

        <p style="position:absolute;top:285px;left:718px;white-space:nowrap" class="ft13">
            by birth
        </p>
        <p style="position:absolute;top:285px;left:701px;white-space:nowrap" class="inputs">
            {{-- {{ @$personalinfos->Citizenship == 'Dual Citizenship (By Birth)' ? 'X' : '' }} --}}
        </p>

        <p style="position:absolute;top:286px;left:785px;white-space:nowrap" class="ft13">
            by naturalization
        </p>
        <p style="position:absolute;top:296px;left:768px;white-space:nowrap" class="inputs">
            {{-- {{ @$personalinfos->Citizenship == 'Dual Citizenship (By Naturalization)' ? 'X' : '' }} --}}
        </p>

        <p style="position:absolute;top:313px;left:705px;white-space:nowrap" class="ft19">
            Pls. indicate country:
        </p>
        <p style="position:absolute;top:345px;left:700px;white-space:nowrap" class="inputs">
            {{-- {{ @$personalinfos->Citizenship }} --}}
        </p>

        <p style="position:absolute;top:363px;left:390px;white-space:nowrap;font-size: 9px;" class="ft13">
            17. RESIDENTIAL ADDRESS
        </p>
        <p style="position:absolute;top:378px;left:566px;white-space:nowrap" class="ft13">
            <i>House/Block/Lot No.</i>
        </p>
        <p style="position:absolute;top:378px;left:783px;white-space:nowrap" class="ft13">
            <i>Street</i>
        </p>
        <p style="position:absolute;top:407px;left:569px;white-space:nowrap" class="ft13">
            <i>Subdivision/Village</i>
        </p>
        <p style="position:absolute;top:393px;left:569px;white-space:nowrap" class="ft13">
            {{ @$personalinfos->residentialaddress }}
        </p>
        <p style="position:absolute;top:407px;left:776px;white-space:nowrap" class="ft13">
            <i>Barangay</i>
        </p>
        <p style="position:absolute;top:438px;left:573px;white-space:nowrap" class="ft13">
            <i>City/Municipality</i>
        </p>
        <p style="position:absolute;top:438px;left:778px;white-space:nowrap" class="ft13">
            <i>Province</i>
        </p>

        <p style="position:absolute;top:457px;left:433px;white-space:nowrap" class="ft13">
            ZIP CODE
        </p>
        <p style="position:absolute;top:458px;left:685px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->zipcode1 }}
        </p>

        <p style="position:absolute;top:482px;left:390px;white-space:nowrap;font-size: 9px;" class="ft13">
            18. PERMANENT ADDRESS
        </p>
        <p style="position:absolute;top:496px;left:566px;white-space:nowrap" class="ft13">
            <i>House/Block/Lot No.</i>
        </p>
        <p style="position:absolute;top:496px;left:783px;white-space:nowrap" class="ft13">
            <i>Street</i>
        </p>
        <p style="position:absolute;top:526px;left:569px;white-space:nowrap" class="ft13">
            <i>Subdivision/Village</i>
        </p>
        <p style="position:absolute;top:511px;left:569px;white-space:nowrap" class="ft13">
            {{ @$personalinfos->permanentAddress }}
        </p>
        <p style="position:absolute;top:526px;left:776px;white-space:nowrap" class="ft13">
            <i>Barangay</i>
        </p>
        <p style="position:absolute;top:558px;left:573px;white-space:nowrap" class="ft13">
            <i>City/Municipality</i>
        </p>
        <p style="position:absolute;top:558px;left:778px;white-space:nowrap" class="ft13">
            <i>Province</i>
        </p>

        <p style="position:absolute;top:579px;left:433px;white-space:nowrap" class="ft13">
            ZIP CODE
        </p>
        <p style="position:absolute;top:579px;left:685px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->zipcode2 }}
        </p>

        <p style="position:absolute;top:610px;left:390px;white-space:nowrap" class="ft13">
            19. TELEPHONE NO.
        </p>
        <p style="position:absolute;top:610px;left:540px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->telephone2 }}
        </p>

        <p style="position:absolute;top:640px;left:390px;white-space:nowrap" class="ft13">
            20. MOBILE NO.
        </p>
        <p style="position:absolute;top:640px;left:540px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->cellphone }}
        </p>

        <p style="position:absolute;top:670px;left:390px;white-space:nowrap;font-size: 9px;" class="ft13">
            21. E-MAIL ADDRESS (if any)
        </p>
        <p style="position:absolute;top:670px;left:540px;white-space:nowrap" class="f-inputs">
            {{ @$personalinfos->email }}
        </p>


        {{-- II. FAMILY BACKGROUND --}}
        <p style="position:absolute;top:696px;left:24px;white-space:nowrap" class="ft14"><i><b>II.  FAMILY BACKGROUND</b></i></p>
        <p style="position:absolute;top:720px;left:24px;white-space:nowrap" class="ft13">22. SPOUSE'S SURNAME</p>
        <p style="position:absolute;top:720px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseSurname }}
        </p>

        <p style="position:absolute;top:743px;left:41px;white-space:nowrap" class="ft13">  FIRST NAME</p>
        <p style="position:absolute;top:745px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseFirstname }}
        </p>

        <p style="position:absolute;top:741px;left:390px;white-space:nowrap" class="ft10">NAME EXTENSION (JR., SR)</p>

        <p style="position:absolute;top:770px;left:41px;white-space:nowrap" class="ft13">  MIDDLE NAME</p>
        <p style="position:absolute;top:771px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseMiddlename }}
        </p>

        <p style="position:absolute;top:797px;left:41px;white-space:nowrap" class="ft13">OCCUPATION</p>
        <p style="position:absolute;top:797px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseOccupation }}
        </p>

        <p style="position:absolute;top:825px;left:41px;white-space:nowrap;font-size:9px;" class="ft13">EMPLOYER/BUSINESS NAME</p>
        <p style="position:absolute;top:824px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseBussiness }}
        </p>

        <p style="position:absolute;top:850px;left:41px;white-space:nowrap" class="ft13">BUSINESS ADDRESS</p>
        <p style="position:absolute;top:850px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseBussinessAddress }}
        </p>

        <p style="position:absolute;top:875px;left:41px;white-space:nowrap" class="ft13">TELEPHONE NO.</p>
        <p style="position:absolute;top:875px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->spouseTelephone }}
        </p>

        <p style="position:absolute;top:901px;left:25px;white-space:nowrap" class="ft13">24. FATHER'S SURNAME</p>
        <p style="position:absolute;top:901px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->fatherSurname }}
        </p>

        <p style="position:absolute;top:925px;left:41px;white-space:nowrap" class="ft13">FIRST NAME</p>
        <p style="position:absolute;top:927px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->fatherFirstname }}
        </p>

        <p style="position:absolute;top:923px;left:390px;white-space:nowrap" class="ft10">NAME EXTENSION (JR., SR)</p>
        <p style="position:absolute;top:920px;left:390px;white-space:nowrap" class="inputs">
            {{-- {{ @$fb->FatherMiddlename }} --}}
        </p>

        <p style="position:absolute;top:955px;left:41px;white-space:nowrap" class="ft13">MIDDLE NAME</p>
        <p style="position:absolute;top:955px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->fatherMiddlename }}
        </p>

        <p style="position:absolute;top:979px;left:24px;white-space:nowrap" class="ft13">25. MOTHER'S MAIDEN NAME</p>
        <p style="position:absolute;top:979px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->motherMaidenName }}
        </p>

        <p style="position:absolute;top:1005px;left:41px;white-space:nowrap" class="ft13">SURNAME</p>
        <p style="position:absolute;top:1005px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->motherSurname }}
        </p>

        <p style="position:absolute;top:1032px;left:41px;white-space:nowrap" class="ft13">FIRST NAME</p>
        <p style="position:absolute;top:1032px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->motherFirstname }}
        </p>

        <p style="position:absolute;top:1058px;left:41px;white-space:nowrap" class="ft13">MIDDLE NAME</p>
        <p style="position:absolute;top:1058px;left:202px;white-space:nowrap" class="f-inputs">
            {{ @$fb->motherMiddlename }}
        </p>

        <p style="position:absolute;top:720px;left:519px;white-space:nowrap" class="ft13">23. NAME of CHILDREN  (Write full name and list all)</p>
        <p style="position:absolute;top:717px;left:807px;white-space:nowrap;font-size: 8px;" class="ft13">DATE OF BIRTH</p>
        <p style="position:absolute;top:726px;left:815px;white-space:nowrap;font-size: 8px;" class="ft13">(mm/dd/yyyy)</p>
        <table style="width:365px;position:absolute;top:738px;left:519px; border-collapse:separate;border-spacing:0px;text-align:center; vertical-align:center;line-height:33px;">
            <tr>
                <th class="" style="width: 70%;"></th>
                <th class="" style="width: 30%"></th>
            </tr>
            <tbody>
                @foreach ($children as $child)
                <tr>
                    <td style="border-collapse:collapse;height:23.8px;border-spacing:0;">
                        <p class="inputs">
                            {{ @$child->name }}
                        </p>
                    </td>
                    <td style="border-collapse:collapse;height:23.8px;border-spacing:0;">
                        <p class="inputs">
                            {{ @$child->birthday }}
                        </p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="position:absolute;top:1059px;left:625px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>

        {{-- III. EDUCATIONAL BACKGROUND --}}
        <p style="position:absolute;top:1080px;left:24px;white-space:nowrap" class="ft14"><i><b>III.  EDUCATIONAL BACKGROUND</b></i></p>
        <p style="position:absolute;top:1105px;left:25px;white-space:nowrap" class="ft13">26.</p>
        <p style="position:absolute;top:1120px;left:80px;white-space:nowrap" class="ft13">LEVEL</p>
        <p style="position:absolute;top:1115px;left:235px;white-space:nowrap" class="ft13">NAME OF SCHOOL</p>
        <p style="position:absolute;top:1130px;left:252px;white-space:nowrap" class="ft13">(Write in full)</p>
        <div style="position:absolute;top:1154px;left:171px;height:35.5px;width:213.5px;display:table">
           <div style="display:table-cell;vertical-align:middle;text-align:center;">
                <p class="inputs">
                    {{ @$eb->elemSchoolName }}
                </p>
           </div>
        </div>
        <div style="position:absolute;top:1191px;left:171px;height:35.5px;width:213.5px;display:table">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                <p class="inputs">
                    {{ @$eb->secSchoolName }}
                </p>
           </div>
        </div>
        <div style="position:absolute;top:1226px;left:171px;height:35.5px;width:213.5px;display:table">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                <p class="inputs">
                    {{ @$eb->vocSchoolName }}
                </p>
           </div>
        </div>
        <div style="position:absolute;top:1263px;left:171px;height:35.5px;width:213.5px;display:table">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                <p class="inputs">
                    {{ @$eb->collSchoolName1 }}
                </p>
           </div>
        </div>
        <div style="position:absolute;top:1297px;left:171px;height:35.5px;width:213.5px;display:table">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                <p class="inputs">
                    {{ @$eb->gradSchoolName }}
                </p>
           </div>
        </div>
        <p style="position:absolute;top:1115px;left:395px;white-space:nowrap" class="ft13">BASIC EDUCATION/DEGREE/COURSE </p>
        <p style="position:absolute;top:1130px;left:455px;white-space:nowrap" class="ft13">(Write in full)         </p>
        <div style="position:absolute;top:1154px;left:388px;height:33px;width:193px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemDegree }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:388px;height:33px;width:193px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemDegree }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:388px;height:33px;width:193px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocDegree }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:388px;height:33px;width:193px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collDegree1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:388px;height:33px;width:193px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradDegree }}
                 </p>
            </div>
        </div>
        <p style="position:absolute;top:1117px;left:597px;white-space:nowrap" class="ft10">PERIOD OF ATTENDANCE</p>
        <p style="position:absolute;top:1140px;left:600px;white-space:nowrap" class="ft13">From</p>
        <div style="position:absolute;top:1154px;left:583px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemFrom }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:583px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->secFrom }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:583px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocFrom }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:583px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collFrom1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:583px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradFrom }}
                 </p>
            </div>
        </div>
        <p style="position:absolute;top:1141px;left:657px;white-space:nowrap" class="ft13">To</p>
        <div style="position:absolute;top:1154px;left:636px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemTo }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:636px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->secTo }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:636px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocTo }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:636px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collTo1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:636px;height:33px;width:52px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradTo }}
                 </p>
            </div>
        </div>
        <p style="position:absolute;top:1110px;left:707px;white-space:nowrap" class="ft10">HIGHEST LEVEL/<br></p>
        <p style="position:absolute;top:1120px;left:709px;white-space:nowrap" class="ft10">UNITS EARNED</p>
        <p style="position:absolute;top:1130px;left:707px;white-space:nowrap" class="ft10">(if not graduated)</p>
        <div style="position:absolute;top:1154px;left:690px;height:33px;width:79px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemHighestLevel }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:690px;height:33px;width:79px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->secHighestLevel }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:690px;height:33px;width:79px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocHighestLevel }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:690px;height:33px;width:79px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collHighestLevel1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:690px;height:33px;width:79px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradHighestLevel }}
                 </p>
            </div>
        </div>

        <p style="position:absolute;top:1115px;left:790px;white-space:nowrap" class="ft10">YEAR</p>
        <p style="position:absolute;top:1125px;left:780px;white-space:nowrap" class="ft10">GRADUATED</p>
        <div style="position:absolute;top:1154px;left:771.5px;height:33px;width:61px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemYear }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:771.5px;;height:33px;width:61px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->secYear }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:771.5px;;height:33px;width:61px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocYear }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:771.5px;;height:33px;width:61px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collHighestLevel1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:771.5px;;height:33px;width:61px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradYear }}
                 </p>
            </div>
        </div>

        <p style="position:absolute;top:1105px;left:846px;white-space:nowrap" class="ft10">SCHOLARSHIP/</p>
        <p style="position:absolute;top:1115px;left:850px;white-space:nowrap" class="ft10">ACADEMIC</p>
        <p style="position:absolute;top:1125px;left:853px;white-space:nowrap" class="ft10">HONORS</p>
        <p style="position:absolute;top:1135px;left:851px;white-space:nowrap" class="ft10">RECEIVED</p>
        <div style="position:absolute;top:1154px;left:833.5px;height:33px;width:65px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->elemSOA }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1191px;left:833.5px;height:33px;width:65px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->secSOA }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1226px;left:833.5px;height:33px;width:65px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->vocSOA }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1263px;left:833.5px;height:33px;width:65px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->collSOA1 }}
                 </p>
            </div>
        </div>
        <div style="position:absolute;top:1297px;left:833.5px;height:33px;width:65px;display:table;">
            <div style="display:table-cell;vertical-align:middle;text-align:center;">
                 <p class="inputs">
                     {{ @$eb->gradSOA }}
                 </p>
            </div>
        </div>
        <p style="position:absolute;top:1166px;left:41px;white-space:nowrap" class="ft13">ELEMENTARY</p>
        <p style="position:absolute;top:1203px;left:41px;white-space:nowrap" class="ft13">SECONDARY</p>
        <p style="position:absolute;top:1234px;left:41px;white-space:nowrap" class="ft13">VOCATIONAL /<br/>TRADE COURSE</p>
        <p style="position:absolute;top:1275px;left:41px;white-space:nowrap" class="ft13">COLLEGE</p>
        <p style="position:absolute;top:1309px;left:41px;white-space:nowrap" class="ft13">GRADUATE STUDIES </p>

        {{-- FOOTER --}}
        <p style="position:absolute;top:1336px;left:378px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>
        <p style="position:absolute;top:1358px;left:64px;white-space:nowrap" class="ft112"><i><b>SIGNATURE</b></i></p>
        <p style="position:absolute;top:1358px;left:621px;white-space:nowrap" class="ft112"><i><b>DATE</b></i></p>
        <p style="position:absolute;top:1385px;left:725px;white-space:nowrap" class="ft11"><i>CS FORM 212 (Revised 2017), Page 1 of 4</i></p>

    </div>
        {{-- SHEET2 --}}
    <div class="page-break" id="page2-div" style="position:relative;width:918px;height:1404px; margin-top: 20px;">
        @include('reports.pds_images.page2')

        <p style="position:absolute;top:30px;left:22px;white-space:nowrap" class="ft14"><i><b>IV.  CIVIL SERVICE ELIGIBILITY</b></i></p>
        <p style="position:absolute;top:55px;left:20px;white-space:nowrap" class="ft11">27.</p>
        <p style="position:absolute;top:55px;left:55px;white-space:nowrap" class="ft11">CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER</p>
        <p style="position:absolute;top:70px;left:105px;white-space:nowrap" class="ft11">SPECIAL LAWS/ CES/ CSEE</p>
        <p style="position:absolute;top:85px;left:70px;white-space:nowrap" class="ft11">BARANGAY ELIGIBILITY / DRIVER'S LICENSE</p>
        <p style="position:absolute;top:65px;left:323px;white-space:nowrap" class="ft11">RATING</p>
        <p style="position:absolute;top:78px;left:310px;white-space:nowrap" class="ft11">(If Applicable)</p>
        <p style="position:absolute;top:55px;left:420px;white-space:nowrap" class="ft11">DATE OF</p>
        <p style="position:absolute;top:68px;left:407px;white-space:nowrap" class="ft11">EXAMINATION /</p>
        <p style="position:absolute;top:82px;left:408px;white-space:nowrap" class="ft11">CONFERMENT</p>
        <p style="position:absolute;top:70px;left:538px;white-space:nowrap" class="ft11">PLACE OF EXAMINATION / CONFERMENT</p>
        <p style="position:absolute;top:53px;left:782px;white-space:nowrap" class="ft11">LICENSE (if applicable)</p>
        <p style="position:absolute;top:78px;left:780px;white-space:nowrap" class="ft11">NUMBER</p>
        <p style="position:absolute;top:72px;left:858px;white-space:nowrap" class="ft11">Date of</p>
        <p style="position:absolute;top:86px;left:858px;white-space:nowrap" class="ft11">Validity</p>
        <p style="position:absolute;top:350px;left:373px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>

        <table id="eli-tlb" style="width:882px;position:absolute;top:100px;left:19px; border-collapse:collapse;border-spacing:0px;table-layout: fixed;text-align:center;">
            <tbody>
                <tr>
                    <th class="" style="width: 31%;"></th>
                    <th class="" style="width: 10%;"></th>
                    <th class="" style="width: 12%;"></th>
                    <th class="" style="width: 29%;"></th>
                    <th class="" style="width: 9%;"></th>
                    <th class="" style="width: 7%;"></th>
                </tr>
                @foreach ($eligibilities as $eligibility)
                    <tr>
                        <td style="border-collapse:collapse;height:32.5px;border-spacing:0;">
                            <p class="inputs">
                                {{ @$eligibility->careerService }}
                            </p>
                        </td>
                        <td style="border-collapse:collapse;height:32px;border-spacing:0;">
                            <p class="inputs">
                                {{ @$eligibility->rating }}
                            </p>
                        </td>
                        <td style="border-collapse:collapse;height:32px;border-spacing:0px;">
                            <p class="inputs">
                                {{ @$eligibility->dateOfExam }}
                            </p>
                        </td>
                        <td style="border-collapse:collapse;height:32px;border-spacing:0;">
                            <p class="inputs">
                                {{ @$eligibility->placeOfExam }}
                            </p>
                        </td>
                        <td style="border-collapse:collapse;height:32px;border-spacing:0;">
                            <p class="inputs">
                                {{ @$eligibility->licenseNumber }}
                            </p>
                        </td>
                        <td style="border-collapse:collapse;height:32px;border-spacing:0;">
                            <p class="inputs">
                                {{ @$eligibility->licenseRelease }}
                            </p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p style="position:absolute;top:365px;left:22px;white-space:nowrap" class="ft14"><i><b>V.  WORK EXPERIENCE</b></i></p>
        <p style="position:absolute;top:385px;left:22px;white-space:nowrap" class="ft11"><i><b>(Include private employment.  Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.)</b></i></p>
        <p style="position:absolute;top:410px;left:21px;white-space:nowrap" class="ft11">28.</p>
        <p style="position:absolute;top:410px;left:50px;white-space:nowrap" class="ft11">INCLUSIVE DATES</p>
        <p style="position:absolute;top:423px;left:63px;white-space:nowrap" class="ft11">(mm/dd/yyyy)</p>
        <p style="position:absolute;top:450px;left:40px;white-space:nowrap" class="ft11">From</p>
        <p style="position:absolute;top:450px;left:120px;white-space:nowrap" class="ft11">To</p>
        <p style="position:absolute;top:425px;left:235px;white-space:nowrap" class="ft11">POSITION TITLE</p>
        <p style="position:absolute;top:438px;left:205px;white-space:nowrap" class="ft11">(Write in full/Do not abbreviate)</p>
        <p style="position:absolute;top:425px;left:405px;white-space:nowrap" class="ft11">DEPARTMENT / AGENCY / OFFICE / COMPANY</p>
        <p style="position:absolute;top:438px;left:445px;white-space:nowrap" class="ft11">(Write in full/Do not abbreviate)</p>
        <p style="position:absolute;top:425px;left:634px;white-space:nowrap" class="ft11">MONTHLY </p>
        <p style="position:absolute;top:438px;left:637px;white-space:nowrap" class="ft11">SALARY</p>
        <p style="position:absolute;top:410px;left:694px;white-space:nowrap" class="ft10">SALARY/ JOB/ PAY</p>
        <p style="position:absolute;top:420px;left:709px;white-space:nowrap" class="ft10">GRADE (if </p>
        <p style="position:absolute;top:430px;left:698px;white-space:nowrap" class="ft10">applicable) STEP</p>
        <p style="position:absolute;top:440px;left:700px;white-space:nowrap" class="ft10">(Format &#34;00-0&#34;)/ </p>
        <p style="position:absolute;top:450px;left:705px;white-space:nowrap" class="ft10">INCREMENT</p>
        <p style="position:absolute;top:425px;left:775px;white-space:nowrap" class="ft11">STATUS OF </p>
        <p style="position:absolute;top:438px;left:768px;white-space:nowrap" class="ft11">APPOINTMENT</p>
        <p style="position:absolute;top:418px;left:856px;white-space:nowrap" class="ft11">GOV'T </p>
        <p style="position:absolute;top:430px;left:850px;white-space:nowrap" class="ft11">SERVICE   </p>
        <p style="position:absolute;top:443px;left:858px;white-space:nowrap" class="ft11">(Y/ N)</p>

        <table id="we-tbl" style="width:882px;position:absolute;top:466px;left:19px; border-collapse:separate;border-spacing:0px;table-layout: fixed;text-align:center;">
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

                    @foreach ($workExperiences as $workexperience)
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
        <p style="position:absolute;top:1360px;left:55px;white-space:nowrap" class="ft112"><i><b>SIGNATURE</b></i></p>
        <p style="position:absolute;top:1360px;left:543px;white-space:nowrap" class="ft112"><i><b>DATE</b></i></p>
        <p style="position:absolute;top:1336px;left:373px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>
        <p style="position:absolute;top:1385px;left:725px;white-space:nowrap" class="ft11"><i>CS FORM 212 (Revised 2017), Page 2 of 4</i></p>
    </div>

    @if(count($workExperiences_cont) >= 1)
        @include('reports.workExCont')
    @endif

    {{-- SHEET 3 --}}
    <div class="page-break" id="page3-div" style="position:relative;width:918px;height:1404px; margin-top: 20px;">
        @include('reports.pds_images.page3')
        <p style="position:absolute;top:33px;left:26px;white-space:nowrap" class="ft14"><i><b>VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S</b></i></p>
        <p style="position:absolute;top:65px;left:31px;white-space:nowrap" class="ft11">29.</p>
        <p style="position:absolute;top:65px;left:140px;white-space:nowrap" class="ft11">NAME &amp; ADDRESS OF ORGANIZATION     </p>
        <p style="position:absolute;top:80px;left:190px;white-space:nowrap" class="ft11">(Write in full)</p>
        <p style="position:absolute;top:60px;left:430px;white-space:nowrap" class="ft11">INCLUSIVE DATES     </p>
        <p style="position:absolute;top:70px;left:442px;white-space:nowrap" class="ft11">(mm/dd/yyyy)</p>
        <p style="position:absolute;top:86px;left:429px;white-space:nowrap" class="ft11">From</p>
        <p style="position:absolute;top:86px;left:501px;white-space:nowrap" class="ft11">To</p>
        <p style="position:absolute;top:73px;left:540px;white-space:nowrap" class="ft10">NUMBER OF HOURS</p>
        <p style="position:absolute;top:75px;left:680px;white-space:nowrap" class="ft11">POSITION / NATURE OF WORK</p>

        <table style="width:875px;position:absolute;top:97px;left:24px; border-collapse:separate;border-spacing:0px;table-layout: fixed; text-align:center;">
            <tr>
                <th style="width: 38.1%;"></th>
                <th style="width: 7%;"></th>
                <th style="width: 7%;"></th>
                <th style="width: 6.5%;"></th>
                <th style="width: 30%;"></th>
            </tr>
            <tbody>
            @foreach ($voluntaryworks as $voluntarywork)
                <tr>
                    <td style="border-collapse:collapse;height:30.5px;border-spacing:0;"><p class="inputs">{{@$voluntarywork->nameAndAddress}}</p></td>
                    <td style="border-collapse:collapse;height:30.5px;border-spacing:0;"><p class="inputs">{{ Str::before(@$voluntarywork->inclusiveDates, '/*/')}}</p></td>
                    <td style="border-collapse:collapse;height:30.5px;border-spacing:0;"><p class="inputs">{{ Str::after(@$voluntarywork->inclusiveDates, '/*/')}}</p></td>
                    <td style="border-collapse:collapse;height:30.5px;border-spacing:0;"><p class="inputs">{{@$voluntarywork->hours}}</p></td>
                    <td style="border-collapse:collapse;height:30.5px;border-spacing:0;"><p class="inputs">{{@$voluntarywork->position}}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <p style="position:absolute;top:331px;left:386px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>

        <p style="position:absolute;top:347px;left:26px;white-space:nowrap" class="ft14"><i><b>VII.  LEARNING AND DEVELOPMENT (L&amp;D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</b></i></p>
        <p style="position:absolute;top:385px;left:31px;white-space:nowrap" class="ft11">30.</p>
        <p style="position:absolute;top:385px;left:70px;white-space:nowrap;font-size: 8px;" class="ft11">TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS          </p>
        <p style="position:absolute;top:400px;left:190px;white-space:nowrap" class="ft11">(Write in full)</p>
        <p style="position:absolute;top:373px;left:425px;white-space:nowrap" class="ft11">INCLUSIVE DATES OF </p>
        <p style="position:absolute;top:385px;left:442px;white-space:nowrap" class="ft11">ATTENDANCE    </p>
        <p style="position:absolute;top:397px;left:443px;white-space:nowrap" class="ft11">(mm/dd/yyyy)</p>
        <p style="position:absolute;top:418px;left:429px;white-space:nowrap" class="ft11">From</p>
        <p style="position:absolute;top:418px;left:501px;white-space:nowrap" class="ft11">To</p>
        <p style="position:absolute;top:395px;left:539px;white-space:nowrap" class="ft10">NUMBER OF HOURS</p>
        <p style="position:absolute;top:380px;left:625px;white-space:nowrap" class="ft10">Type of LD</p>
        <p style="position:absolute;top:390px;left:622px;white-space:nowrap" class="ft10"> ( Managerial/ </p>
        <p style="position:absolute;top:400px;left:623px;white-space:nowrap" class="ft10">Supervisory/</p>
        <p style="position:absolute;top:410px;left:621px;white-space:nowrap" class="ft10">Technical/etc) </p>
        <p style="position:absolute;top:385px;left:720px;white-space:nowrap" class="ft11"> CONDUCTED/ SPONSORED BY   </p>
        <p style="position:absolute;top:400px;left:755px;white-space:nowrap" class="ft11">(Write in full)</p>

        <table style="width:887px;position:absolute;top:429px;left:17px; border-collapse:separate;border-spacing:0px;table-layout: fixed; text-align:center;">
            <tr>
                <th style="width: 39%;"></th>
                <th style="width: 7%;"></th>
                <th style="width: 7%;"></th>
                <th style="width: 7%;"></th>
                <th style="width: 7.5%;"></th>
                <th style="width: 23%;"></th>
            </tr>
            <tbody>
                @foreach ($trainingPrograms as $trainingprogram)
                <tr>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs">{{@$trainingprogram->title}}</p></td>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs">{{ @$trainingprogram->inclusiveDateFrom }}</p></td>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs">{{ @$trainingprogram->inclusiveDateTo }}</p></td>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs">{{@$trainingprogram->hours}}</p></td>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs"></p></td>
                    <td style="border-collapse:collapse;height:27.2px;border-spacing:0;"><p class="inputs">{{@$trainingprogram->conductor}}</p></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <p style="position:absolute;top:1049px;left:386px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>

        <p style="position:absolute;top:1067px;left:26px;white-space:nowrap" class="ft14"><i><b>VIII.  OTHER INFORMATION</b></i></p>
        <p style="position:absolute;top:1103px;left:35px;white-space:nowrap" class="ft11">31.</p>
        <p style="position:absolute;top:1103px;left:70px;white-space:nowrap" class="ft11">SPECIAL SKILLS and HOBBIES</p>
        <p style="position:absolute;top:1103px;left:256px;white-space:nowrap" class="ft11">32.</p>
        <p style="position:absolute;top:1095px;left:360px;white-space:nowrap" class="ft11">NON-ACADEMIC DISTINCTIONS / RECOGNITION          </p>
        <p style="position:absolute;top:1110px;left:430px;white-space:nowrap" class="ft11">(Write in full)</p>
        <p style="position:absolute;top:1103px;left:686px;white-space:nowrap" class="ft11">33.</p>
        <p style="position:absolute;top:1095px;left:705px;white-space:nowrap;font-size: 8px;" class="ft11">MEMBERSHIP IN ASSOCIATION/ORGANIZATION     </p>
        <p style="position:absolute;top:1110px;left:770px;white-space:nowrap" class="ft11">(Write in full)</p>

        <table style="width:875px;position:absolute;top:1128px;left:24px; border-collapse:separate;border-spacing:0px;table-layout: fixed; text-align:center;">
            <tr>
                <th style="width: 25%;"></th>
                <th style="width: 50%;"></th>
                <th style="width: 25%;"></th>
            </tr>
            <tbody>
                @foreach ($otherinfos as $otherinfo)
                <tr>
                    <td style="border-collapse:collapse;height:27px;border-spacing:0;"><p class="inputs">{{@$otherinfo->skill}}</p></td>
                    <td style="border-collapse:collapse;height:27px;border-spacing:0;"><p class="inputs">{{@$otherinfo->recognition}}</p></td>
                    <td style="border-collapse:collapse;height:27px;border-spacing:0;"><p class="inputs">{{@$otherinfo->membership}}</p></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="position:absolute;top:1337px;left:386px;white-space:nowrap" class="ft15"><i><b>(Continue on separate sheet if necessary)</b></i></p>
        <p style="position:absolute;top:1360px;left:104px;white-space:nowrap" class="ft112"><i><b>SIGNATURE</b></i></p>
        <p style="position:absolute;top:1360px;left:593px;white-space:nowrap" class="ft112"><i><b>DATE</b></i></p>
        <p style="position:absolute;top:1385px;left:725px;white-space:nowrap" class="ft11"><i>CS FORM 212 (Revised 2017), Page 3 of 4</i></p>
    </div>

    @if(count($trainingPrograms_cont) >= 1)
        @include('reports.trainingProgCont')
    @endif

    {{-- SHEET 4 --}}
    <div class="page-break" id="page3-div" style="position:relative;width:918px;height:1404px; margin-top: 20px;">
        @include('reports.pds_images.page4')
        <p style="position:absolute;top:32px;left:23px;white-space:nowrap" class="ft19">34.</p>
        <p style="position:absolute;top:32px;left:45px;white-space:nowrap" class="ft19">Are you related by consanguinity or affinity to the appointing or recommending authority, or to the</p>
        <p style="position:absolute;top:51px;left:45px;white-space:nowrap" class="ft19">chief of bureau or office or to the person who has immediate supervision over you in the Office, </p>
        <p style="position:absolute;top:68px;left:45px;white-space:nowrap" class="ft19">Bureau or Department where you will be apppointed,</p>
        <p style="position:absolute;top:90px;left:45px;white-space:nowrap" class="ft19">a. within the third degree?</p>
        <p style="position:absolute;top:90px;left:607px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:90px;left:589px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q34a == '1' ? 'X' : '' }}</p>

        <p style="position:absolute;top:90px;left:699px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:90px;left:681px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q34a == '0' ? 'X' : '' }}</p>

        <p style="position:absolute;top:115px;left:45px;white-space:nowrap" class="ft19">b. within the fourth degree (for Local Government Unit - Career Employees)?</p>
        <p style="position:absolute;top:115px;left:607px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:114px;left:589px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q34b == '1' ? 'X' : '' }}</p>

        <p style="position:absolute;top:115px;left:699px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:114px;left:681px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q34b == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:133px;left:571px;white-space:nowrap" class="ft19">     If YES, give details: </p>

        <div style="position:absolute;top:145px;left:600px; width: 286px; height: 23px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q34bdetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:182px;left:23px;white-space:nowrap" class="ft19">35.</p>
        <p style="position:absolute;top:182px;left:45px;white-space:nowrap" class="ft19">a. Have you ever been found guilty of any administrative offense?</p>

        <p style="position:absolute;top:186.5px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:186.5px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q35a == '1' ? 'X' : '' }}</p>

        <p style="position:absolute;top:186.5px;left:700px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:186.5px;left:682px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q35a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:203px;left:571px;white-space:nowrap" class="ft19">     If YES, give details: </p>

        <div style="position:absolute;top:215px;left:600px; width: 286px; height: 23px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q35adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:258px;left:45px;white-space:nowrap" class="ft19">b. Have you been criminally charged before any court?</p>
        <p style="position:absolute;top:262px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:262px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q35b == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:262px;left:705px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:262px;left:687px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q35b == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:279px;left:571px;white-space:nowrap" class="ft19">     If YES, give details: </p>
        <p style="position:absolute;top:295px;left:619px;white-space:nowrap" class="ft19">Date Filed: </p>

        <div style="position:absolute;top:300px;left:695px; width: 190px; height: 16px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q35bdatefiled }}</p>
            </div>
        </div>

        <p style="position:absolute;top:319px;left:586px;white-space:nowrap" class="ft19">Status of Case/s:</p>

        <div style="position:absolute;top:319px;left:695px; width: 190px; height: 16px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q35bcasestatus }}</p>
            </div>
        </div>

        <p style="position:absolute;top:355px;left:23px;white-space:nowrap" class="ft19">36.</p>
        <p style="position:absolute;top:351px;left:45px;white-space:nowrap" class="ft19">Have you ever been convicted of any crime or violation of any law, decree, ordinance or regulation by <br/>any court or tribunal?</p>
        <p style="position:absolute;top:355px;left:604px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:355px;left:586px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q36a == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:355px;left:709px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:355px;left:691px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q36a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:373px;left:571px;white-space:nowrap" class="ft19">     If YES, give details:</p>

        <div style="position:absolute;top:385px;left:600px; width: 286px; height: 23px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q36adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:426px;left:23px;white-space:nowrap" class="ft19">37.</p>
        <p style="position:absolute;top:425px;left:45px;white-space:nowrap" class="ft19">Have you ever been separated from the service in any of the following modes: resignation, retirement, <br/>dropped from the rolls, dismissal, termination, end of term, finished contract or phased out (abolition) <br/>in the public or private sector?</p>
        <p style="position:absolute;top:431px;left:603px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:429px;left:585px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q37a == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:431px;left:711px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:429px;left:693px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q37a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:444px;left:571px;white-space:nowrap" class="ft19">     If YES, give details: </p>

        <div style="position:absolute;top:450px;left:600px; width: 286px; height: 23px;  display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q37adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:488px;left:23px;white-space:nowrap" class="ft19">38.</p>
        <p style="position:absolute;top:484px;left:45px;white-space:nowrap" class="ft19">a. Have you ever been a candidate in a national or local election held within the last year (except <br/>Barangay election)?</p>
        <p style="position:absolute;top:492px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:492px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q38a == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:492px;left:719px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:492px;left:701px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q38a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:507px;left:593px;white-space:nowrap" class="ft19">If YES, give details:</p>

        <div style="position:absolute;top:507px;left:695px; width: 190px; height: 16px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q38adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:534px;left:45px;white-space:nowrap" class="ft19">b. Have you resigned from the government service during the three (3)-month period before the last <br/>election to promote/actively campaign for a national or local candidate?</p>
        <p style="position:absolute;top:536px;left:606px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:537px;left:588px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q38b == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:537px;left:720px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:538px;left:701px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q38b == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:555px;left:593px;white-space:nowrap" class="ft19">If YES, give details:</p>

        <div style="position:absolute;top:555px;left:695px; width: 190px; height: 16px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q38bdetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:583px;left:23px;white-space:nowrap" class="ft19">39.</p>
        <p style="position:absolute;top:583px;left:45px;white-space:nowrap" class="ft19">Have you acquired the status of an immigrant or permanent resident of another country?</p>
        <p style="position:absolute;top:590px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:590px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q39a == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:590px;left:719px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:590px;left:701px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q39a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:605px;left:571px;white-space:nowrap" class="ft19">     If YES, give details (country): </p>

        <div style="position:absolute;top:616px;left:600px; width: 286px; height: 20px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q39adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:653px;left:23px;white-space:nowrap" class="ft19">40.</p>
        <p style="position:absolute;top:653px;left:45px;white-space:nowrap" class="ft19">Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA 7277); <br/>and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:</p>
        <p style="position:absolute;top:688px;left:20px;white-space:nowrap" class="ft19">a. </p>
        <p style="position:absolute;top:689px;left:45px;white-space:nowrap" class="ft19">Are you a member of any indigenous group?</p>
        <p style="position:absolute;top:700px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:700px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40a == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:700px;left:721px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:700px;left:703px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40a == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:712px;left:571px;white-space:nowrap" class="ft19">If YES, please specify:</p>

        <div style="position:absolute;top:707px;left:755px; width: 130px; height: 16px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q40adetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:726px;left:20px;white-space:nowrap" class="ft19">b. </p>
        <p style="position:absolute;top:726px;left:45px;white-space:nowrap" class="ft19">Are you a person with disability?</p>
        <p style="position:absolute;top:736px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:737px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40b == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:736px;left:721px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:737px;left:703px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40b == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:748px;left:571px;white-space:nowrap" class="ft19">If YES, please specify ID No: </p>

        <div style="position:absolute;top:745px;left:755px; width: 130px; height: 16px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q40bdetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:765px;left:20px;white-space:nowrap" class="ft19">c. </p>
        <p style="position:absolute;top:765px;left:45px;white-space:nowrap" class="ft19">Are you a solo parent?</p>
        <p style="position:absolute;top:777px;left:605px;white-space:nowrap" class="ft19">YES</p>
        <p style="position:absolute;top:777px;left:587px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40c == '1' ? 'X' : '' }}</p>
        <p style="position:absolute;top:777px;left:721px;white-space:nowrap" class="ft19">NO</p>
        <p style="position:absolute;top:777px;left:703px;white-space:nowrap" class="ft19">{{ @$pdsquestions->q40c == '0' ? 'X' : '' }}</p>
        <p style="position:absolute;top:789px;left:571px;white-space:nowrap" class="ft19">If YES, please specify ID No: </p>

        <div style="position:absolute;top:780px;left:755px; width: 130px; height: 16px;   display: table;">
            <div class="" style="text-align:center; vertical-align: middle;display:table-cell">
                <p class="inputs">{{ @$pdsquestions->q40cdetails }}</p>
            </div>
        </div>

        <p style="position:absolute;top:825px;left:23px;white-space:nowrap" class="ft19">41.</p>
        <p style="position:absolute;top:825px;left:44px;white-space:nowrap" class="ft19">REFERENCES </p>
        <p style="position:absolute;top:825px;left:125px;white-space:nowrap;color:red" class="ft19">(Person not related by consanguinity or affinity to applicant /appointee)</p>
        <p style="position:absolute;top:854px;left:173px;white-space:nowrap" class="ft19">NAME</p>
        <p style="position:absolute;top:854px;left:440px;white-space:nowrap" class="ft19">ADDRESS</p>
        <p style="position:absolute;top:854px;left:603px;white-space:nowrap" class="ft19">TEL. NO.</p>

        <table style="width:663px;position:absolute;top:873px;left:15px; border-collapse:separate;border-spacing:0px;table-layout: fixed; text-align:center;">
            <tr>
                <th style="width: 37%;"></th>
                <th style="width: 23%;"></th>
                <th style="width: 12%;"></th>
            </tr>
            <tbody>
                <tr>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refname1}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refaddress1}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->reftelephone1}}</p></td>
                </tr>
                <tr>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refname2}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refaddress2}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->reftelephone2}}</p></td>
                </tr>
                <tr>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refname3}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->refaddress3}}</p></td>
                    <td style="border-collapse:collapse;height:30px;"><p class="inputs">{{@$pdsquestions->reftelephone3}}</p></td>
                </tr>
            </tbody>
        </table>

        <p style="position:absolute;top:978px;left:23px;white-space:nowrap" class="ft19">42.</p>
        <p style="position:absolute;top:978px;left:45px;white-space:nowrap;font-size: 12px;" class="ft19">
            I declare under oath that I have personally accomplished
            this Personal Data Sheet which is a true, correct and<br/>
            complete statement pursuant to the provisions of pertinent laws,
            rules and regulations of the Republic of the<br/>Philippines. I
            authorize the agency head/authorized representative to verify/validate
            the contents stated herein.<br/> I agree that any misrepresentation
            made in this document and its attachments shall cause
            the filing of<br/>administrative/criminal case/s against me.
        </p>

        <p style="position:absolute;top:868px;left:743px;white-space:nowrap" class="ft19">ID picture taken within </p>
        <p style="position:absolute;top:880px;left:753px;white-space:nowrap" class="ft19">the last  6 months</p>
        <p style="position:absolute;top:891px;left:754px;white-space:nowrap" class="ft19">4.5 cm. X 3.5 cm</p>
        <p style="position:absolute;top:902px;left:759px;white-space:nowrap" class="ft19">(passport size)</p>
        <p style="position:absolute;top:937px;left:747px;white-space:nowrap" class="ft19">Computer  generated </p>
        <p style="position:absolute;top:948px;left:743px;white-space:nowrap" class="ft19">or photocopied  picture </p>
        <p style="position:absolute;top:959px;left:755px;white-space:nowrap" class="ft19">is not acceptable</p>
        <p style="position:absolute;top:1027px;left:775px;white-space:nowrap" class="ft19">PHOTO</p>

        <p style="position:absolute;top:1090px;left:31px;white-space:nowrap" class="ft19">Government Issued ID</p>
        <p style="position:absolute;top:1092px;left:140px;white-space:nowrap; font-size: 7px;" class="ft19"> (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)</p>
        <p style="position:absolute;top:1112px;left:31px;white-space:nowrap" class="ft19">
            <i>
                PLEASE INDICATE ID Number and Date of Issuance
            </i>
        </p>
        <p style="position:absolute;top:1133px;left:31px;white-space:nowrap" class="ft19">Government Issued ID: </p>
        <p style="position:absolute;top:1162px;left:31px;white-space:nowrap" class="ft19">ID/License/Passport No.: </p>
        <p style="position:absolute;top:1192px;left:31px;white-space:nowrap" class="ft19">Date/Place of Issuance:</p>

        <div style="position: absolute; top:1125px;left:150px;width:180px;display:table; text-align:center;">
            <div style="display: table-row">
                <div class="" style="height: 29px;vertical-align: middle;display:table-cell">
                    <p class="inputs">{{@$pdsquestions->govid}}</p>
                </div>
            </div>
            <div style="display: table-row">
                <div class="" style="height: 29px;vertical-align: middle;display:table-cell">
                    <p class="inputs">{{@$pdsquestions->idnumber}}</p>
                </div>
            </div>
            <div style="display: table-row">
                <div class="" style="height: 29px;vertical-align: middle;display:table-cell">
                    <p class="inputs">{{@$pdsquestions->dateissued}}</p>
                </div>
            </div>
        </div>

        <p style="position:absolute;top:1168px;left:453px;white-space:nowrap" class="ft19">Signature (Sign inside the box)</p>
        <p style="position:absolute;top:1200px;left:476px;white-space:nowrap" class="ft19">Date Accomplished</p>

        <p style="position:absolute;top:1200px;left:755px;white-space:nowrap" class="ft19">Right Thumbmark</p>

        <p style="position:absolute;top:1240px;left:65px;white-space:nowrap" class="ft19">SUBSCRIBED AND SWORN to before me this
        <p style="position:absolute;top:1240px;left:490px;white-space:nowrap" class="ft19">affiant exhibiting his/her validly issued government ID as indicated above.</p>

        <p style="position:absolute;top:1348px;left:436px;white-space:nowrap" class="ft19">Person Administering Oath</p>
        <p style="position:absolute;top:1385px;left:725px;white-space:nowrap" class="ft11"><i>CS FORM 212 (Revised 2017),  Page 4 of 4</i></p>
    </div></body></html>

