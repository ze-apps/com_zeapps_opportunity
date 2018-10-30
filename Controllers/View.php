<?php

namespace App\com_zeapps_opportunity\Controllers;

use Zeapps\Core\Controller;

class View extends Controller
{
    public function view(){
        $data = array();
        return view("opportunities/view", $data, BASEPATH . 'App/com_zeapps_opportunity/views/');
    }

    public function opportunitiesSearch(){
        $data = array();
        return view("opportunities/search", $data, BASEPATH . 'App/com_zeapps_opportunity/views/');
    }

    public function opportunitiesFormModal(){
        $data = array();
        return view("opportunities/form_modal", $data, BASEPATH . 'App/com_zeapps_opportunity/views/');
    }

    public function opportunitiesModal(){
        $data = array();
        return view("opportunities/modalCompany", $data, BASEPATH . 'App/com_zeapps_opportunity/views/');
    }

    public function summary_partial(){
        $data = array();
        return view("opportunities/summary_partial", $data, BASEPATH . 'App/com_zeapps_opportunity/views/');
    }
}