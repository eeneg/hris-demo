@inject('carbon', 'Carbon\Carbon')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

       <style>
            html {
                font-family: 'Times New Roman', Times, serif;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%
            }
            body {
                height: 13in;
                width: 9in;
                font-family: 'Times New Roman', Times, serif;
                margin: 0
            }
            .container-fluid {
                margin-left:auto;
                margin-right:auto;
                width:100%
            }

            .table{
                color:#111827;
                margin-bottom:1rem;
                width:100%;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 0;
            }
            .table td,.table th{
                border-top:1px solid #e5e7eb;
                padding:.75rem;
                vertical-align:top
            }
            .table thead th{
                border-bottom:2px solid #e5e7eb;
                vertical-align:bottom
            }
            .table tbody+tbody{
                border-top:2px solid #e5e7eb
            }
            .table-bordered,.table-bordered td,.table-bordered th{
                border:1px solid #e5e7eb
            }
            .table-bordered thead td,.table-bordered thead th{
                border-bottom-width:2px
            }
            .table-borderless tbody+tbody,.table-borderless td,.table-borderless th,.table-borderless thead th{
                border:0
            }
            .table-striped tbody tr:nth-of-type(odd){
                background-color:rgba(0,0,0,.05)
            }
            .text-center{
                text-align:center!important
            }
            .table-bordered {
                border:1px solid black;
                border-collapse: collapse;
            }

            @media print {
                .page-break { page-break-before: always; } /* page-break-after works, as well */
                .tableHead th {
                    background-color: #AEAEAE; !important;
                    print-color-adjust: exact;
                }
            }
       </style>

    </head>
    <body style="background-color: white">
        <div class="container-fluid" style="padding: 10px; width: 100%;" >
            <div style="display:block; text-align:right">
               <p style="font-size: 10px;">
                    Revised as of January 2015 <br>
                    Per CSC Resolution No. 1500088 <br>
                    Promulgated on January 23, 2015 <br>
               </p>
            </div>
            <div style="display: block; text-align:center; padding:0; font-weight:bold; font-size: 20px;">
                <p style="padding:0; margin: 0;">SWORN STATEMENT OF ASSETS, LIABILITIES AND NET WORTH</p>
            </div>
            <div style="display: block; text-align:center; padding:0; font-size: 13px;">
                <p style="padding:0; margin: 0;">As of JANUARY 2024</p>
            </div>
            <div style="display: block; text-align:center; padding:0; font-size: 10px;">
                <p style="padding:0; margin: 0;">(Required by R.A. 6713)</p>
            </div>
            <div style="display: block; text-align:center; padding:0; font-size: 10px;">
                <p style="padding:0; margin: 10px 0 0 0;">
                    <span style="font-weight: bold;">Note:</span>
                    Husband and wife who are both public officials and employees may file the required statements jointly or separately.
                </p>
            </div>
            <div style="display: block; text-align:center;">
                <article>
                    <span style="padding: 0; margin: 5px; font-size: 9px;"> Joint Filing</span>
                    <span style="padding: 0; margin: 5px; font-size: 9px;"> Separate Filing</span>
                    <span style="padding: 0; margin: 5px; font-size: 9px;"> Not Applicable</span>
                </article>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%;">
                <div style="width: 15%; font-weight:bold; font-size: 13px;">
                    Declarant:
                </div>
                <div style="width: 35%; margin-left: 10px; border-bottom: 1px solid; font-size: 13px; display:flex; justify-content:space-around;">
                    <div>{{$saln->declarant_fn}}</div>
                    <div>{{$saln->declarant_ln}} {{$saln->declarant_name_extension}}</div>
                    <div>{{$saln->declarant_mi}}</div>
                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Position:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{ $saln->declarant_position }}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0;">
                <div style="width: 15%; font-weight:bold;">

                </div>
                <div style="display: flex; justify-content: space-around; align-items: center; width: 35%; margin-left: 10px; font-size: 10px; margin-top: 0;">
                    <div>
                        (Family Name)
                    </div>
                    <div>
                        (First Name)
                    </div>
                    <div>
                        (Middle Initial)
                    </div>
                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Agency/Office:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{$saln->declarant_agency}}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0; font-size: 13px;">
                <div style="width: 15%; font-weight:bold;">
                    Address
                </div>
                <div style="width: 35%; margin-left: 10px; border-bottom: 1px solid; font-size: 13px; text-align: center;">
                    {{$saln->declarant_address}}
                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Office Address:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{$saln->declarant_office_address}}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0;">
                <div style="width: 15%; font-weight:bold;">

                </div>
                <div style="width: 35%; margin-left: 10px; border-bottom: 1px solid;">

                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px;">

                </div>
                <div style="width: 30%; border-bottom: 1px solid;">

                </div>
            </div>
            <div style="display: inline-flex; width: 100%;">
                <div style="width: 15%; font-weight:bold; font-size: 13px;">
                    Spouse:
                </div>
                <div style="width: 35%; margin-left: 10px; border-bottom: 1px solid; font-size: 13px; display:flex; justify-content:space-around;">
                    <div>{{$saln->spouse_fn}}</div>
                    <div>{{$saln->spouse_ln}}</div>
                    <div>{{$saln->spouse_mi}}</div>
                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Position:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{$saln->spouse_position}}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0;">
                <div style="width: 15%; font-weight:bold;">

                </div>
                <div style="display: flex; justify-content: space-around; align-items: center; width: 35%; margin-left: 10px; font-size: 10px; margin-top: 0;">
                    <div>
                        (Family Name)
                    </div>
                    <div>
                        (First Name)
                    </div>
                    <div>
                        (Middle Initial)
                    </div>
                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Agency/Office:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{$saln->spouse_agency}}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0;">
                <div style="width: 15%; font-weight:bold;">

                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; width: 35%; margin-left: 10px; font-size: 10px; margin-top: 0;">

                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px; font-size: 13px;">
                    Office Address:
                </div>
                <div style="width: 30%; border-bottom: 1px solid; font-size: 13px; text-align:center;">
                    {{$saln->spouse_agency_address}}
                </div>
            </div>
            <div style="margin: 10px 0 0 0; display: inline-flex; width: 100%; margin-top: 0;">
                <div style="width: 15%; font-weight:bold;">

                </div>
                <div style="width: 35%; margin-left: 10px;">

                </div>
                <div style="width: 15%; font-weight:bold; margin-left: 30px;">

                </div>
                <div style="width: 30%; border-bottom: 1px solid;">

                </div>
            </div>
            <div style="display: block; border: 1px solid; margin-top: 15px; padding: 0"></div>
            <div style="margin-top: 10px; display: block; text-align:center; font-size: 15px; font-weight: bold;">
                UNMARRIED CHILDREN BELOW EIGHTEEN (18) YEARS OF AGE LIVING IN DECLARANT’S HOUSEHOLD
            </div>
            <div style="display: block; margin-top: 10px; padding: 20px;">
                <table style="width: 100%; font-size: 13px;">
                    <thead>
                        <tr>
                            <th>NAME</th>
                            <th>DATE OF BIRTH</th>
                            <th>AGE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_children as $children)
                            <tr>
                                <td style="border-bottom: 1px solid; text-align:center; width: 50%;">{{$children->name}}</td>
                                <td style="border-bottom: 1px solid; text-align:center; width: 25%">{{$children->dob}}</td>
                                <td style="border-bottom: 1px solid; text-align:center; width: 25%">{{$children->age}}</td>
                            </tr>
                        @endforeach()
                    </tbody>
                </table>
            </div>
            <div style="display: block; border: 1px solid; margin-top: 5px; padding: 0"></div>
            <div style="display: block; text-align:center; font-weight: bold; font-size: 15px; margin-top: 10px;">
                ASSETS, LIABILITIES AND NETWORTH
            </div>
            <div style="display: block; text-align:center; font-style: italic; font-size: 10px;">
                (Including those of the spouse and unmarried children below eighteen (18)
                years of age living in declarant’s household)
            </div>
            <div style="font-size: 10px; font-weight:bold;">
                1.  ASSETS
            </div>
            <div style="font-size: 10px; font-weight:bold; margin-left: 20px; margin-top: 10px;">
                a.	Real Properties*
            </div>
            <div style="display: block; margin-top: 10px;">
                <table class="table-bordered tableHead" style="width: 100%; font-size: 13px;">
                    <thead style="border: 1px solid">
                        <tr>
                            <th rowspan="2" class="tableHead" style="border: 1px solid; background-color: #AEAEAE;">
                                <p>DESCRIPTION</p>
                                <p style="font-size: 10px;">(e.g. lot, house and lot, condominium and improvements)</p>
                            </th>
                            <th rowspan="2" style="border: 1px solid; background-color: #AEAEAE;">
                                <p>KIND</p>
                                <p style="font-size: 10px;">(e.g. residential, commercial, industrial, agricultural and mixed use)</p>
                            </th>
                            <th rowspan="2" style="border: 1px solid; background-color: #AEAEAE;;">EXACT LOCATION</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">ASSESSED VALUE</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">CURRENT FAIR MARKET VALUE</th>
                            <th colspan="2"  style="border: 1px solid; background-color: #AEAEAE;">ACQUISITION</th>
                            <th rowspan="2" style="border: 1px solid; background-color: #AEAEAE;">ACQUISITION COST</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="border: 1px solid; font-size: 10px; background-color: #AEAEAE;">(As found in the Tax Declaration of Real Property)</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">YEAR</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">MODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_realProperty as $srp)
                            <tr>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->description }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->kind }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->location }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->assessed_value }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->market_value }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->acquisition_year }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->acquisition_mode }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $srp->acquisition_cost }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="display: flex; justify-content: end; width: 100%; font-size: 13px;border: 1px; margin-top:5px;">
                    <div>
                        Subtotal:
                    </div>
                    <div style="border-bottom: 1px solid; width: 20%; text-align:center">
                        {{ $saln->real_property_subtotal }}
                    </div>
                </div>
            </div>
            <div style="font-size: 10px; font-weight:bold; margin-left: 20px; margin-top: 10px;">
                b.	Personal Properties*
            </div>
            <div style="display: block; margin-top: 10px;">
                <table class="table-bordered" style="width: 100%; font-size: 13px;">
                    <thead style="border: 1px solid">
                        <tr>
                            <th style="border: 1px solid; background-color: #AEAEAE;">DESCRIPTION</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">YEAR ACQUIRED</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">ACQUISITION COST/AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_personalProperty as $spp)
                            <tr>
                                <td style="border: 1px solid; text-align:center; width: 50%">{{ $spp->description }}</td>
                                <td style="border: 1px solid; text-align:center; width: 25%">{{ $spp->year }}</td>
                                <td style="border: 1px solid; text-align:center; width: 25%">{{ $spp->cost }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="display: flex; justify-content: end; width: 100%; font-size: 13px;border: 1px; margin-top:5px;">
                    <div>
                        Subtotal:
                    </div>
                    <div style="border-bottom: 1px solid; width: 20%; text-align:center">
                        {{ $saln->personal_property_subtotal }}
                    </div>
                </div>
                <div style="display: flex; justify-content: end; width: 100%; font-size: 13px;border: 1px; margin-top:5px;">
                    <div style="font-weight: bold;">
                        Total Assets (a+b):
                    </div>
                    <div style="border-bottom: 1px solid; width: 20%; text-align:center">
                        {{ $saln->total_asset }}
                    </div>
                </div>
            </div>
            <div style="font-size: 10px; font-weight:bold; margin-left: 20px; margin-top: 10px;">
                2.	Liabilities*
            </div>
            <div style="display: block; margin-top: 10px;">
                <table class="table-bordered" style="width: 100%; font-size: 13px;">
                    <thead style="border: 1px solid">
                        <tr>
                            <th style="border: 1px solid; background-color: #AEAEAE;">NATURE</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">NAME OF CREDITORS</th>
                            <th style="border: 1px solid; background-color: #AEAEAE;">OUTSTANDING BALANCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_liability as $sl)
                            <tr>
                                <td style="border: 1px solid; text-align:center;">{{ $sl->nature }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $sl->creditor_name }}</td>
                                <td style="border: 1px solid; text-align:center;">{{ $sl->balance }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div style="display: flex; justify-content: end; width: 100%; font-size: 13px;border: 1px; margin-top:5px;">
                    <div>
                        Total Liabilities:
                    </div>
                    <div style="border-bottom: 1px solid; width: 20%; text-align:center">
                        {{ $saln->total_liability }}
                    </div>
                </div>
                <div style="display: flex; justify-content: end; width: 100%; font-size: 13px;border: 1px; margin-top:5px;">
                    <div style="font-weight: bold;">
                        NET WORTH: Total Assets less Total Liabilities =
                    </div>
                    <div style="border-bottom: 1px solid; width: 20%; text-align:center">
                        {{ $saln->net_worth }}
                    </div>
                </div>
            </div>
            <div style="font-size: 13px; font-style:italic;">
                * Additional sheet/s may be used, if necessary.
            </div>
            <div class="page-break" style="display: block; text-align:center; font-weight: bold; font-size: 15px; margin-top: 20px;">
                BUSINESS INTERESTS AND FINANCIAL CONNECTIONS
            </div>
            <div style="display: block; text-align:center; font-style: italic; font-size: 10px;">
                (Of Declarant /Declarant’s spouse/ Unmarried Children Below Eighteen (18) years of Age Living in Declarant’s Household)
            </div>
            <div style="display: block; text-align:center; font-style: italic; font-size: 10px; margin-top:3px;">
                 I/We do not have any business interest or financial connection.
            </div>
            <div style="display: block; margin-top: 10px;">
                <table class="table-bordered" style="width: 100%; font-size: 13px;">
                    <thead style="border: 1px solid">
                        <tr>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 30%;">NAME OF ENTITY/BUSINESS ENTERPRISE</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 30%;">BUSINESS ADDRESS</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 20%;">NATURE OF BUSINESS INTEREST &/OR FINANCIAL CONNECTION</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 20%;">DATE OF ACQUISITION OF INTEREST OR CONNECTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_business as $sb)
                            <tr>
                                <td style="border: 1px solid; text-align:center;">{{$sb->name}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sb->address}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sb->nature}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sb->date}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display: block; text-align:center; font-weight: bold; font-size: 15px; margin-top: 20px;">
                RELATIVES IN THE GOVERNMENT SERVICE
            </div>
            <div style="display: block; text-align:center; font-style: italic; font-size: 10px;">
                (Within the Fourth Degree of Consanguinity or Affinity. Include also Bilas, Balae and Inso)
            </div>
            <div style="display: block; text-align:center; font-style: italic; font-size: 10px; margin-top:3px;">
                 I/We do not know of any relative/s in the government service)
            </div>
            <div style="display: block; margin-top: 10px;">
                <table class="table-bordered" style="width: 100%; font-size: 13px;">
                    <thead style="border: 1px solid">
                        <tr>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 30%;">NAME OF RELATIVE</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 15%;">RELATIONSHIP</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 30%;">POSITION</th>
                            <th style="border: 1px solid; background-color: #AEAEAE; width: 25%;">NAME OF AGENCY/OFFICE AND ADDRESS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($saln_relative   as $sr)
                            <tr>
                                <td style="border: 1px solid; text-align:center;">{{$sr->name}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sr->relationship}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sr->postion}}</td>
                                <td style="border: 1px solid; text-align:center;">{{$sr->agency_name_and_address}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 30px;text-indent: 8%;">
                I hereby certify that these are true and correct statements of my assets, liabilities, net worth,
                business interests and financial connections, including those of my spouse and unmarried children
                below eighteen (18) years of age living in my household, and that to the best of my knowledge, the
                above-enumerated are names of my relatives in the government within the fourth civil degree of consanguinity
                or affinity.
            </div>
            <div style="margin-top: 20px;text-indent: 8%;">
                I hereby authorize the Ombudsman or his/her duly authorized representative to obtain and secure from
                all appropriate government agencies, including the Bureau of Internal Revenue such documents that may
                show my assets, liabilities, net worth, business interests and financial connections, to include those
                of my spouse and unmarried children below 18 0years of age living with me in my household covering previous
                years to include the year I first assumed office in government.
            </div>
            <div style="display: flex; margin-top: 20px;">
                <div>
                    Date:
                </div>
                <div style="width:25%; border-bottom: 1px solid; margin-left: 25px;">

                </div>
            </div>
            <div style="display: block;">
                <div>

                </div>
                <div>

                </div>
            </div>
            <div style="display: inline-flex; width: 100%; margin-top: 20px;">
                <div style="width: 40%; border-bottom: 1px solid; text-align:center;">
                </div>
                <div style="width: 20%;">

                </div>
                <div style="width: 40%; border-bottom: 1px solid; text-align:center;">
                </div>
            </div>
            <div style="display: inline-flex; width: 100%;">
                <div style="width: 40%; text-align:center; font-size: 13px;">
                    (Signature of Declarant)
                </div>
                <div style="width: 20%;">

                </div>
                <div style="width: 40%; text-align:center; font-size: 13px;">
                    (Signature of Co-Declarant/Spouse)
                </div>
            </div>
            <div style="display: inline-flex; width: 100%; margin-top: 20px;">
                <div style="width: 40%;">
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px;">
                            Government Issued ID:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px;">
                            {{ $saln->gov_id1 }}
                        </div>
                    </div>
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px;">
                            ID No.:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px; text-align:center;">
                            {{ $saln->idNo_id1  }}
                        </div>
                    </div>
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px;">
                            Date Issued:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px; text-align:center;">
                            {{ $saln->idDate_id1  }}
                        </div>
                    </div>
                </div>
                <div style="width: 20%;">

                </div>
                <div style="width: 40%;">
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px; text-align:center;">
                            Government Issued ID:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px;">
                            {{ $saln->gov_id2 }}
                        </div>
                    </div>
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px;">
                            ID No.:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px; text-align:center;">
                            {{ $saln->idNo_id2 }}
                        </div>
                    </div>
                    <div style="width: 100%; display: inline-flex">
                        <div style="width: 40%; font-size: 13px;">
                            Date Issued:
                        </div>
                        <div style="width: 60%; text-align:center;border-bottom: 1px solid; font-size: 13px; text-align:center;">
                            {{ $saln->idDate_id2 }}
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: block; margin-top: 20px; text-indent: 8%;">
                SUBSCRIBED AND SWORN to before me this <span>asd</span> day of <span>asd</span>, affiant exhibiting to me the above-stated government issued identification card.
            </div>
            <div style="display: inline-flex; width: 100%;">
                <div style="width: 50%;">

                </div>
                <div style="width: 30%; border-bottom: 1px solid; text-align:center;">

                </div>
                <div style="width: 20%;">

                </div>
            </div>
            <div style="display: inline-flex; width: 100%;">
                <div style="width: 50%;">

                </div>
                <div style="width: 30%; text-align:center; font-size: 13px;">
                    (Person Administering Oath)
                </div>
                <div style="width: 20%;">

                </div>
            </div>
        </div>
    </body>
</html>
