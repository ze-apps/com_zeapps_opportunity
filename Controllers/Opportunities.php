<?php

namespace App\com_zeapps_opportunity\Controllers;

use App\com_zeapps_opportunity\Models\Activity;
use App\com_zeapps_opportunity\Models\Note;
use App\com_zeapps_opportunity\Models\Status;
use Zeapps\Core\Controller;
use Zeapps\Core\Request;
use App\com_zeapps_opportunity\Models\Opportunity as OpportunitiesModel;
use Zeapps\libraries\PHPExcel;

class Opportunities extends Controller
{
    public function getAll(Request $request)
    {
        $filters = array() ;

        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);
        $context = $request->input('context', false);

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && (isset($_SERVER['CONTENT_TYPE']) && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE)) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $opportunities_rs = OpportunitiesModel::orderBy('name') ;
        foreach ($filters as $key => $value) {
            if (strpos($key, " LIKE")) {
                $key = str_replace(" LIKE", "", $key);
                $opportunities_rs = $opportunities_rs->where($key, 'like', '%' . $value . '%') ;
            } else {
                $opportunities_rs = $opportunities_rs->where($key, $value) ;
            }
        }

        $total = $opportunities_rs->count();
        $opportunities_rs_id = $opportunities_rs ;

        $opportunities = $opportunities_rs->limit($limit)->offset($offset)->get();

        if(!$opportunities) {
            $opportunities = array();
        }


        $ids = [];
        if($total < 500) {
            $rows = $opportunities_rs_id->select(array("id"))->get();
            foreach ($rows as $row) {
                array_push($ids, $row->id);
            }
        }

        if ($context) {
            $activities = Activity::orderBy('label')->get();
            if (!$activities) {
                $activities = array();
            }

            $status = Status::orderBy('label')->get();
            if (!$status) {
                $status = array();
            }
        } else {
            $activities = array();
            $status = array();
        }

        echo json_encode(array(
            'activities' => $activities,
            'status' => $status,
            'opportunities' => $opportunities,
            'total' => $total,
            'ids' => $ids
        ));
    }

    public function modal(Request $request)
    {
        $limit = $request->input('limit', 15);
        $offset = $request->input('offset', 0);

        $filters = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }

        $opportunities_rs = OpportunitiesModel::orderBy('name') ;
        foreach ($filters as $key => $value) {
            if (strpos($key, " LIKE")) {
                $key = str_replace(" LIKE", "", $key);
                $opportunities_rs = $opportunities_rs->where($key, 'like', '%' . $value . '%') ;
            } else {
                $opportunities_rs = $opportunities_rs->where($key, $value) ;
            }
        }

        $total = $opportunities_rs->count();


        $opportunities = $opportunities_rs->limit($limit)->offset($offset)->get();

        if(!$opportunities) {
            $opportunities = array();
        }

        echo json_encode(array("data" => $opportunities, "total" => $total));
    }

    public function context(Request $request)
    {
        $id_opportunity = $request->input('id_opportunity', 0);

        if(!$activities = Activity::orderBy('id')->get()) {
            $activities = array();
        }

        if(!$status = Status::orderBy('id')->get()) {
            $status = array();
        }

        if(!$notes = Note::where('id_opportunity', $id_opportunity)->orderBy('id', 'DESC')->limit(4)->get()) {
            $notes = array();
        }

        echo json_encode(array('activities' => $activities, 'status' => $status, 'notes' => $notes));
    }

    public function get(Request $request)
    {
        $id = $request->input('id', 0);

        $opportunity = OpportunitiesModel::where('id', $id)->first();

        if (!$opportunity) {
            $opportunity = [];
        }

        $activities = Activity::orderBy('label')->get() ;

        echo json_encode(array(
            'activities' => $activities,
            'opportunity' => $opportunity
        ));
    }

    public function save()
    {
        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $opportunity = new OpportunitiesModel() ;

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $opportunity = OpportunitiesModel::where('id', $data["id"])->first() ;
        }

        foreach ($data as $key =>$value) {
            $opportunity->$key = $value ;
        }

        $opportunity->save();

        echo $opportunity->id;
    }

    public function delete(Request $request) {

        $id = $request->input('id', 0);

        echo json_encode(OpportunitiesModel::where('id', $id)->delete());
    }

    public function make_export(){
        $filters = [];

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $filters = json_decode(file_get_contents('php://input'), true);
        }


        $companies_rs = CompaniesModel::orderBy('company_name') ;
        foreach ($filters as $key => $value) {
            if (strpos($key, " LIKE")) {
                $key = str_replace(" LIKE", "", $key);
                $companies_rs = $companies_rs->where($key, 'like', '%' . $value . '%') ;
            } else {
                $companies_rs = $companies_rs->where($key, $value) ;
            }
        }

        $companies = $companies_rs->get();



        if($companies){

            $objPHPExcel = new PHPExcel();

            $objPHPExcel->getActiveSheet()->setCellValue('A1', "Raison Sociale");
            $objPHPExcel->getActiveSheet()->setCellValue('B1', "Compagnie mère");
            $objPHPExcel->getActiveSheet()->setCellValue('C1', "Type de compte");
            $objPHPExcel->getActiveSheet()->setCellValue('D1', "Topologie");
            $objPHPExcel->getActiveSheet()->setCellValue('E1', "Domaine d'activité");
            $objPHPExcel->getActiveSheet()->setCellValue('F1', "Chiffre d'affaires");
            $objPHPExcel->getActiveSheet()->setCellValue('G1', "Adresse de facturation 1");
            $objPHPExcel->getActiveSheet()->setCellValue('H1', "Adresse 2");
            $objPHPExcel->getActiveSheet()->setCellValue('I1', "Adresse 3");
            $objPHPExcel->getActiveSheet()->setCellValue('J1', "Ville");
            $objPHPExcel->getActiveSheet()->setCellValue('K1', "Code postal");
            $objPHPExcel->getActiveSheet()->setCellValue('L1', "Etat");
            $objPHPExcel->getActiveSheet()->setCellValue('M1', "Pays");
            $objPHPExcel->getActiveSheet()->setCellValue('N1', "Adresse de livraison 1");
            $objPHPExcel->getActiveSheet()->setCellValue('O1', "Adresse 2");
            $objPHPExcel->getActiveSheet()->setCellValue('P1', "Adresse 3");
            $objPHPExcel->getActiveSheet()->setCellValue('Q1', "Ville");
            $objPHPExcel->getActiveSheet()->setCellValue('R1', "Code postal");
            $objPHPExcel->getActiveSheet()->setCellValue('S1', "Etat");
            $objPHPExcel->getActiveSheet()->setCellValue('T1', "Pays");
            $objPHPExcel->getActiveSheet()->setCellValue('U1', "Email");
            $objPHPExcel->getActiveSheet()->setCellValue('V1', "Telephone");
            $objPHPExcel->getActiveSheet()->setCellValue('W1', "Fax");
            $objPHPExcel->getActiveSheet()->setCellValue('X1', "SiteWeb");
            $objPHPExcel->getActiveSheet()->setCellValue('Y1', "Code NAF");
            $objPHPExcel->getActiveSheet()->setCellValue('Z1', "SIRET");

            foreach ($companies as $key => $company) {
                $i = $key + 2;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $company->company_name);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $company->name_parent_company);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $company->name_account_family);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $company->name_topology);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $company->name_activity_area);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $company->turnover);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $company->billing_address_1);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $company->billing_address_2);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $company->billing_address_3);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $i, $company->billing_city);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $i, $company->billing_zipcode);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $i, $company->billing_state);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $i, $company->billing_country_name);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $i, $company->delivery_address_1);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $i, $company->delivery_address_2);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $i, $company->delivery_address_3);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $i, $company->delivery_city);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $i, $company->delivery_zipcode);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $i, $company->delivery_state);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $i, $company->delivery_country_name);
                $objPHPExcel->getActiveSheet()->setCellValue('U' . $i, $company->email);
                $objPHPExcel->getActiveSheet()->setCellValue('V' . $i, $company->phone);
                $objPHPExcel->getActiveSheet()->setCellValue('W' . $i, $company->fax);
                $objPHPExcel->getActiveSheet()->setCellValue('X' . $i, $company->website_url);
                $objPHPExcel->getActiveSheet()->setCellValue('Y' . $i, $company->code_naf_libelle);
                $objPHPExcel->getActiveSheet()->setCellValue('Z' . $i, $company->company_number);
            }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            recursive_mkdir(FCPATH . 'tmp/com_zeapps_opportunity/companies/');

            $objWriter->save(FCPATH . 'tmp/com_zeapps_opportunity/companies/companies.xlsx');

            echo json_encode(true);
        }
        else {
            echo json_encode(false);
        }
    }

    public function get_export(){
        $file_url = FCPATH . 'tmp/com_zeapps_opportunity/companies/companies.xlsx';

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
        readfile($file_url);
    }
}