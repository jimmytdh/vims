<!DOCTYPE html>
<html>
<head>
    <title>{{ $data->firstname." ".$data->lastname }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px !important;
        }
        #wrapper {
            max-width: 480px;
            width: 480px;
            max-height: 340px;
            height: 340px;
            border: 1px solid #000;
            padding:10px;
            font-size: 11px;
            position: relative;
        }
        .logo {
            position: absolute;
            left: 3px;
        }
        .logo img { height: 57px; margin-top:-3px;}
        .barcode {
            position: absolute;
            right:6px;
        }
        .title img{
            height: 50px;
            margin-left: 110px;
            margin-top: 5px;
        }
        hr {
            height:2px;
            border:none;
            color:#333;
            background-color:#333;
            width: 375px;
            margin-top:5px;
            text-align: left;
            margin-left: 0px;
        }
        .line {
            border-bottom: 1px solid #000 !important;
        }
        .top {
            vertical-align: top;
            font-size: 10px;
            font-weight: bold;
        }
        label { font-size: 10px; font-weight: bold;}
        th {
            text-align: left;
        }

        .vac {
            font-size: 9px;
        }
        .vac td, .vac th{
            border:1px solid #000;
            padding: 5px 3px;
        }
        .text-center {
            text-align: center;
        }
        .text-middle {
            vertical-align: middle;
        }
        .alert {
            font-size: 0.8em;
            /*background: #ffa0a0;*/
            color: red;
            padding: 5px;
            width: 365px;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .form-group {
            padding: 5px 0;
        }
        .bg-theme {
            background-color: #000;
            color: #fff;
        }
        .table-info {
            font-size: 12px;
            font-weight: bold;
            font-style: italic;
            font-stretch: condensed;

        }

    </style>
</head>
<body>
    <div id="wrapper">
        <div class="barcode">
            {!! DNS2D::getBarcodeHTML($barcode, 'QRCODE',3,3) !!}
        </div>
        <div class="logo">
            <img src="{{ url('/images/doh_csmc.png') }}" alt="">
        </div>
        <div class="title">
            <img src="{{ url('/images/card_title.png') }}">
        </div>

        <hr/>
        <div class="alert">
            <strong>Please keep this record card</strong>, which includes medical information about vaccines you have received.
        </div>
        <div style="clear: both;"></div>
        <table width="100%" style="margin-top: 10px;">
            <tr>
                <td width="30%">{{ $data->lastname }}</td>
                <td width="30%">{{ $data->firstname }}</td>
                <td width="20%">{{ $data->middlename }}</td>
                <td width="10%">{{ $data->suffix }}</td>
            </tr>
            <tr>
                <td colspan="4" class="line"></td>
            </tr>
            <tr>
                <th class="top">Last Name</th>
                <th class="top">First Name</th>
                <th class="top">Middle Name</th>
                <th class="top">Suffix</th>
            </tr>
            <?php
                $str = substr($data->category, 3);
                $category = str_replace("_"," ",$str);

                $sex = substr($data->sex, 3);
                $sex = str_replace("_"," ",$sex);
            ?>

        </table>

        <table width="100%" style="margin-top: 5px;">
            <?php
                $str = substr($data->category, 3);
                $category = str_replace("_"," ",$str);
            ?>
            <tr>
                <td width="25%">{{ date('M d, Y',strtotime($data->birthdate)) }}</td>
                <td width="15%">{{ substr($data->sex, 3) }}</td>
                <td width="25%">{{ $data->philhealthid }}</td>
                <td width="35%">{{ $category }}</td>
            </tr>
            <tr>
                <td colspan="4" class="line"></td>
            </tr>
            <tr>
                <th class="top">Date of Birth</th>
                <th class="top">Sex</th>
                <th class="top">PhilHealth</th>
                <th class="top">Category</th>
            </tr>
            <?php
            $str = substr($data->category, 3);
            $category = str_replace("_"," ",$str);

            $sex = substr($data->sex, 3);
            $sex = str_replace("_"," ",$sex);
            ?>

        </table>
        <?php
            $brgy = \App\Http\Controllers\AreaController::getBrgybyCode($data->barangay);
            $muncity = \App\Http\Controllers\AreaController::getMuncitybyCode($data->muncity);
            $province = \App\Http\Controllers\AreaController::getProvincebyCode($data->province);
        ?>
        <table width="100%" style="margin-top: 5px;">
            <?php
            $str = substr($data->category, 3);
            $category = str_replace("_"," ",$str);
            ?>
            <tr>
                <td><label>Address: </label> {{ "$brgy, $muncity, $province" }}</td>
            </tr>
        </table>

        <table width="100%" class="vac" cellspacing="0" cellpadding="0" style="margin-top: 5px">
            <tr class="bg-theme">
                <th width="20%" class="text-center">Dosage Seq.</th>
                <th width="20%" class="text-center">Date</th>
                <th width="45%" colspan="2" class="text-center">Vaccine Manufacturer</th>
                <th width="15%" class="text-center">Lot. No.</th>
            </tr>
            <tr>
                <td rowspan="2" class="text-center text-middle">
                    1st Dosage
                </td>
                <td class="text-center">{{ ($data->date_1) ? date('m/d/Y') : '' }}</td>
                <td colspan="2">{{ $data->type }}</td>
                <td>{{ $data->lot_1 }}</td>
            </tr>
            <tr>
                <td colspan="2">Vaccinator Name: {{ $data->vaccinator_1 }}</td>
                <td colspan="2" width="30%">Signature:</td>
            </tr>
            <tr>
                <td rowspan="2" class="text-center text-middle">
                    2nd Dosage
                </td>
                <td class="text-center">{{ ($data->date_2) ? date('m/d/Y') : '' }}</td>
                <td colspan="2">{{ $data->type }}</td>
                <td>{{ $data->lot_2 }}</td>
            </tr>
            <tr>
                <td colspan="2">Vaccinator Name: {{ $data->vaccinator_2 }}</td>
                <td colspan="2">Signature:</td>
            </tr>
        </table>
        <table width="100%" class="table-info">
            <tr>
                <td>Email: csmccebu_doh@yahoo.com</td>
                <td>Contact No.: (032) 273-3226</td>
            </tr>
        </table>
    </div>
</body>
</html>
