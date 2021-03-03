<!DOCTYPE html>
<html>
<head>
    <title>{{ $data->firstname." ".$data->lastname }}</title>
    <style>
        #wrapper {
            max-width: 421px;
            width: 421px;
            max-height: 297px;
            height: 297px;
            border: 1px solid #000;
            padding:10px;
            font-size: 11px;
        }
        .logo {
            float: left;
            margin-right: 5px;
            margin-top: -5px;
        }
        .line {
            border-bottom: 1px solid #000 !important;
        }
        .top {
            vertical-align: top;
            font-size: 0.8em;
            color: #fb8181;
        }
        th {
            text-align: left;
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

            padding: 3px 5px;
            color: #fb8181;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div class="logo">
            <img src="{{ url('/images/logo.png') }}" width="60px" alt="">
        </div>
        Department of Health <br>
        Cebu South Medical Center <br>
        Vaccine Information Management System <br>
        <strong>Information Card</strong>
        <hr>

        <table width="100%">
            <tr>
                <td width="25%">{{ $data->lastname }}</td>
                <td width="25%">{{ $data->firstname }}</td>
                <td width="25%">{{ $data->middlename }}</td>
                <td width="25%">{{ $data->suffix }}</td>
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
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
            <tr>
                <td>{{ date('m/d/Y',strtotime($data->birthdate)) }}</td>
                <td>{{ $sex }}</td>
                <td>{{ $data->philhealthid }}</td>
                <td>{{ $category }}</td>
            </tr>
            <tr>
                <td colspan="4" class="line"></td>
            </tr>
            <tr>
                <th class="top">Date of Birth</th>
                <th class="top">Sex</th>
                <th class="top">PhilHealth ID</th>
                <th class="top">Category</th>
            </tr>
        </table>

        <table width="100%" class="vac" cellspacing="0" cellpadding="0">
            <tr class="bg-theme">
                <th width="20%">Dosage Seq.</th>
                <th width="20%">Date</th>
                <th width="40%" colspan="2">Vaccine Manufacturer</th>
                <th width="20%">Lot. No.</th>
            </tr>
            <tr>
                <td rowspan="2" class="text-center text-middle">
                    1st Dosage
                </td>
                <td class="text-center">/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Vaccinator Name:</td>
                <td colspan="2">Signature:</td>
            </tr>
            <tr>
                <td rowspan="2" class="text-center text-middle">
                    2nd Dosage
                </td>
                <td class="text-center">/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/</td>
                <td colspan="2"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">Vaccinator Name:</td>
                <td colspan="2">Signature:</td>
            </tr>
        </table>
        <div class="alert">
            Please keep this record card, which includes medical information about vaccines you have received.
        </div>
    </div>
</body>
</html>
