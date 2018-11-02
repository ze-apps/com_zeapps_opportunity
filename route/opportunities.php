<?php
use Zeapps\Core\Routeur ;


// Route pour angularJS
Routeur::get('/com_zeapps_opportunity/opportunities/search', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesSearch');
Routeur::get('/com_zeapps_opportunity/opportunities/view', 'App\\com_zeapps_opportunity\\Controllers\\View@view');
Routeur::get('/com_zeapps_opportunity/opportunities/form_modal', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesFormModal');
Routeur::get('/com_zeapps_opportunity/opportunities/modal_company', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesModal');
Routeur::get('/com_zeapps_opportunity/opportunities/summary_partial', 'App\\com_zeapps_opportunity\\Controllers\\View@summary_partial');

Routeur::get('/com_zeapps_opportunity/notes/form_modal', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesFormNote');

Routeur::post("/com_zeapps_opportunity/opportunities/getAll/{limit}/{offset}/{context}", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@getAll');
Routeur::post("/com_zeapps_opportunity/opportunities/modal/{limit}/{offset}", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@modal');
Routeur::post("/com_zeapps_opportunity/opportunities/context/{id_opportunity}", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@context');
Routeur::get("/com_zeapps_opportunity/opportunities/get/{id}", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@get');
Routeur::post("/com_zeapps_opportunity/opportunities/save", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@save');
Routeur::post("/com_zeapps_opportunity/opportunities/delete/{id}", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@delete');
Routeur::post("/com_zeapps_opportunity/opportunities/make_export/", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@make_export');
Routeur::get("/com_zeapps_opportunity/opportunities/get_export/", 'App\\com_zeapps_opportunity\\Controllers\\Opportunities@get_export');


Routeur::post("/com_zeapps_opportunity/notes/getAll/{context}", 'App\\com_zeapps_opportunity\\Controllers\\Notes@getAll');
Routeur::post("/com_zeapps_opportunity/notes/save", 'App\\com_zeapps_opportunity\\Controllers\\Notes@save');

Routeur::get('/com_zeapps_opportunity/test', 'App\\com_zeapps_opportunity\\Controllers\\Test@index');