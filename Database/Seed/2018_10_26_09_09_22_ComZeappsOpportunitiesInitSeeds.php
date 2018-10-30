<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\com_zeapps_opportunity\Models\Opportunity as OpportunityModel;


class ComZeappsOpportunitiesInitSeeds
{
    public function run()
    {
        Capsule::table('zeapps_modules')->insert([
            'module_id' => "com_zeapps_opportunity",
            'label' => "com_zeapps_opportunity",
            'active' => "1",
            'version' => "1.0.0",
            'last_sql' => "0",
            'dependencies' => "",
            'missing_dependencies' => "",
            'created_at'=>'2018-01-01',
            'updated_at'=>'2018-01-01',
        ]);



        // import des opportunités
        Capsule::table('com_zeapps_opportunity_opportunities')->truncate();
        $json_content = json_decode(file_get_contents(dirname(__FILE__) . "/opportunities.json"));
        foreach ($json_content as $data_json) {
            $obj_data = new OpportunityModel();

            foreach ($data_json as $key => $value) {
                $obj_data->$key = $value ;
            }

            $obj_data->save();
        }

    }
}
