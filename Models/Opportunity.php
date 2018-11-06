<?php

namespace App\com_zeapps_opportunity\Models;

use Illuminate\Database\Eloquent\Model ;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Core\ModelHelper;

class Opportunity extends Model {
    use SoftDeletes;

    static protected $_table = 'com_zeapps_opportunity_opportunities';
    protected $table ;

    public function __construct(array $attributes = [])
    {
        $this->table = self::$_table;

        // stock la liste des champs
        $this->fieldModelInfo = new ModelHelper();
        $this->fieldModelInfo->increments('id');

        $this->fieldModelInfo->string('name', 150)->default("");
        $this->fieldModelInfo->float('budget')->default(0);
        $this->fieldModelInfo->date('next_raise')->nullable();

        // Companies
        $this->fieldModelInfo->integer('id_company', false, true)->default(0);
        $this->fieldModelInfo->string('name_company', 255)->default("");

        // Contacts
        $this->fieldModelInfo->integer('id_contact', false, true)->default(0);
        $this->fieldModelInfo->string('name_contact', 255)->default("");

        // User account manager
        $this->fieldModelInfo->integer('id_user_account_manager', false, true)->default(0);
        $this->fieldModelInfo->string('name_user_account_manager', 255)->default("");

        // Activities
        $this->fieldModelInfo->integer('id_activity', false, true)->default(0);
        $this->fieldModelInfo->string('name_activity', 255)->default("");

        // Status
        $this->fieldModelInfo->integer('id_status', false, true)->default(0);
        $this->fieldModelInfo->string('name_status', 255)->default("");
        $this->fieldModelInfo->string('progression', 255)->default("");

        $this->fieldModelInfo->timestamps();
        $this->fieldModelInfo->softDeletes();

        parent::__construct($attributes);
    }

    public static function getSchema() {
        return $schema = Capsule::schema()->getColumnListing(self::$_table) ;
    }

    public function save(array $options = []) {

        /**** to delete unwanted field ****/
        $schema = self::getSchema();
        foreach ($this->getAttributes() as $key => $value) {
            if (!in_array($key, $schema)) {
                //echo $key . "\n" ;
                unset($this->$key);
            }
        }
        /**** end to delete unwanted field ****/

        return parent::save($options);
    }

    public static function getAll() {
        return self::select('com_zeapps_opportunity_opportunities.*', 'com_zeapps_contact_companies.label', 'com_zeapps_contact_companies.company_name')
            ->join('com_zeapps_contact_companies', 'com_zeapps_opportunity_opportunities.id_company', '=', 'com_zeapps_contact_companies.id')
            ->get();
    }
}