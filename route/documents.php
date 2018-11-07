<?php
use Zeapps\Core\Routeur ;


// Route pour angularJS

Routeur::get('/com_zeapps_opportunity/documents/form_modal', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesFormDocument');

Routeur::post("/com_zeapps_opportunity/documents/getAll/{id_user_account_manager}/{id_opportunity}", 'App\\com_zeapps_opportunity\\Controllers\\Documents@getAll');
Routeur::post("/com_zeapps_opportunity/documents/save", 'App\\com_zeapps_opportunity\\Controllers\\Documents@save');
Routeur::post("/com_zeapps_opportunity/documents/delete/{id}", 'App\\com_zeapps_opportunity\\Controllers\\Documents@delete');