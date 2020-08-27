<?php

/********** CONFIG MENU ************/
$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_opportunity_activities" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Activités" ;
$tabMenu["fa-icon"] = "activity" ;
$tabMenu["url"] = "/ng/com_zeapps/opportunity_activities" ;
$tabMenu["access"] = "com_zeapps_opportunity_read" ;
$tabMenu["order"] = 37 ;
$menuLeft[] = $tabMenu ;



$tabMenu = array () ;
$tabMenu["id"] = "com_ze_apps_opportunity_status" ;
$tabMenu["space"] = "com_ze_apps_config" ;
$tabMenu["label"] = "Status" ;
$tabMenu["fa-icon"] = "signal" ;
$tabMenu["url"] = "/ng/com_zeapps/opportunity_status" ;
$tabMenu["access"] = "com_zeapps_opportunity_read" ;
$tabMenu["order"] = 38 ;
$menuLeft[] = $tabMenu ;



/********* insert in essential menu *********/
$tabMenu = array () ;
$tabMenu["label"] = "Opportunités" ;
$tabMenu["url"] = "/ng/com_zeapps_opportunity/opportunities" ;
$tabMenu["access"] = "com_zeapps_opportunity_read" ;
$tabMenu["order"] = 11 ;
$menuEssential[] = $tabMenu ;



/********** insert in left menu ************/
$tabMenu = array () ;
$tabMenu["id"] = "com_zeapps_sales_opportunity" ;
$tabMenu["space"] = "com_ze_apps_sales" ;
$tabMenu["label"] = "Opportunités" ;
$tabMenu["fa-icon"] = "xing" ;
$tabMenu["url"] = "/ng/com_zeapps_opportunity/opportunities" ;
$tabMenu["access"] = "com_zeapps_opportunity_read" ;
$tabMenu["order"] = 2 ;
$menuLeft[] = $tabMenu ;



/********** insert in top menu ************/
$tabMenu = array () ;
$tabMenu["id"] = "com_zeapps_sales_opportunity" ;
$tabMenu["space"] = "com_ze_apps_sales" ;
$tabMenu["label"] = "Opportunités" ;
$tabMenu["url"] = "/ng/com_zeapps_opportunity/opportunities" ;
$tabMenu["access"] = "com_zeapps_opportunity_read" ;
$tabMenu["order"] = 4 ;
$menuHeader[] = $tabMenu ;


