<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ListController extends Controller
{
    public function index()
    {
        return view('admin.list');
    }

    function readFiles()
    {
        $path = public_path('/upload');
        $files = File::allFiles($path);
        $data = array();
        foreach($files as $file)
        {
            $d = $this->csvToArray($file);
            $data = array_merge($data,$d);

        }
        dd(count($data));
    }

    function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            fgetcsv($handle);
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if(!$row[0])
                    break;
                if (!$header)
                    $header = $row;
                else
//                    $data[] = array_combine($header, $row);
                    $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }

    function test()
    {
        $data = array(
            "Category",
            "CategoryID",
            "CategoryIDnumber",
            "PhilHealthID",
            "PWD_ID",
            "Lastname",
            "Firstname",
            "Middlename",
            "Suffix",
            "Contact_no",
            "Full_address",
            "Region",
            "Province",
            "MunCity",
            "Barangay",
            "Sex",
            "Birthdate_",
            "Civilstatus",
            "Employed",
            "Direct_covid",
            "Profession",
            "Employer_name",
            "Employer_LGU",
            "Employer_address",
            "Employer_contact_no",
            "Preg_status",
            "Allergy_01",
            "Allergy_02",
            "Allergy_03",
            "Allergy_04",
            "Allergy_05",
            "Allergy_06",
            "Allergy_07",
            "W_comorbidities",
            "Comorbidity_01",
            "Comorbidity_02",
            "Comorbidity_03",
            "Comorbidity_04",
            "Comorbidity_05",
            "Comorbidity_06",
            "Comorbidity_07",
            "Comorbidity_08",
            "covid_history",
            "covid_date",
            "covid_classification",
            "Consent",
        );
        foreach($data as $row)
        {
            $str = strtolower($row);
            echo "'$str',<br>";
        }
    }
}
