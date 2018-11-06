<?php
use Zeapps\Core\Routeur ;


// Route pour angularJS

Routeur::post("/com_zeapps_opportunity/documents/getAll/{id_user_account_manager}/{id_opportunity}", 'App\\com_zeapps_opportunity\\Controllers\\Documents@getAll');
Routeur::post("/com_zeapps_opportunity/documents/save/{id_user_account_manager}/{id_opportunity}", 'App\\com_zeapps_opportunity\\Controllers\\Documents@save');
Routeur::post("/com_zeapps_opportunity/documents/delete/{id}", 'App\\com_zeapps_opportunity\\Controllers\\Documents@delete');