<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

use App\com_zeapps_opportunity\Models\Activity;
use App\com_zeapps_opportunity\Models\Status;

class ComZeappsOpportunityInit
{

    public function up()
    {

        // ***************************** Activities with seeds (json) **********************************
        Capsule::schema()->create('com_zeapps_opportunity_activity', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');

            $table->timestamps();
            $table->softDeletes();
        });

        Capsule::table('com_zeapps_opportunity_activity')->truncate();
        $activities = json_decode(file_get_contents(dirname(__FILE__) . "/activities.json"));
        foreach ($activities as $activity_json) {
            $activity = new Activity();
            foreach ($activity_json as $key => $value) {
                $activity->$key = $value ;
            }
            $activity->save();
        }

        // ******************************** Status with seeds (json) ***********************************
        Capsule::schema()->create('com_zeapps_opportunity_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label');
            $table->string('progression');

            $table->timestamps();
            $table->softDeletes();
        });

        Capsule::table('com_zeapps_opportunity_status')->truncate();
        $all_status = json_decode(file_get_contents(dirname(__FILE__) . "/status.json"));
        foreach ($all_status as $status_json) {
            $status = new Status();
            foreach ($status_json as $key => $value) {
                $status->$key = $value ;
            }
            $status->save();
        }

        Capsule::schema()->create('com_zeapps_opportunity_opportunities', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name', 255)->default("");
            $table->float('budget')->default(0);
            $table->date('next_raise')->nullable();

            // Companies
            $table->integer('id_company', false, true)->default(0);
            $table->string('name_company', 255)->default("");

            // Contacts
            $table->integer('id_contact', false, true)->default(0);
            $table->string('name_contact', 255)->default("");

            // Activities
            $table->integer('id_activity', false, true)->default(0);
            $table->string('name_activity', 255)->default("");

            // Status
            $table->integer('id_status', false, true)->default(0);
            $table->string('name_status', 255)->default("");
            $table->string('progression', 255)->default("");

            $table->timestamps();
            $table->softDeletes();
        });

        // **************************************** Notes **********************************************
        Capsule::schema()->create('com_zeapps_opportunity_notes', function (Blueprint $table) {

            $table->increments('id');
            $table->text('comments');

            // Opportunities
            $table->integer('id_opportunity', false, true)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        // ************************************** Documents ********************************************
        Capsule::schema()->create('com_zeapps_opportunity_documents', function (Blueprint $table) {

            $table->increments('id');
            $table->string('label');
            $table->string('path');
            $table->string('type', 150);

            // Opportunities
            $table->integer('id_opportunity', false, true)->default(0);

            // Users
            $table->integer('id_user', false, true)->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

    }


    public function down()
    {
        Capsule::schema()->dropIfExists('com_zeapps_opportunity_opportunities');
        Capsule::schema()->dropIfExists('com_zeapps_opportunity_notes');
        Capsule::schema()->dropIfExists('com_zeapps_opportunity_documents');
        Capsule::schema()->dropIfExists('com_zeapps_opportunity_activity');
        Capsule::schema()->dropIfExists('com_zeapps_opportunity_status');
    }
}
