<?php
use Zeapps\Core\Routeur ;


// Route pour angularJS

Routeur::get('/com_zeapps_opportunity/notes/form_modal', 'App\\com_zeapps_opportunity\\Controllers\\View@opportunitiesFormNote');

Routeur::post("/com_zeapps_opportunity/notes/getAll/{id_opportunity}", 'App\\com_zeapps_opportunity\\Controllers\\Notes@getAll');
Routeur::post("/com_zeapps_opportunity/notes/save", 'App\\com_zeapps_opportunity\\Controllers\\Notes@save');
Routeur::post("/com_zeapps_opportunity/notes/delete/{id}", 'App\\com_zeapps_opportunity\\Controllers\\Notes@delete');