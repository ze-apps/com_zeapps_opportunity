<?php

namespace App\com_zeapps_opportunity\Models;

use Illuminate\Database\Eloquent\Model ;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Capsule\Manager as Capsule;
use Zeapps\Core\ModelHelper;

class Document extends Model {
    use SoftDeletes;

    static protected $_table = 'com_zeapps_opportunity_documents';
    protected $table ;

    protected $fieldModelInfo ;

    public function __construct(array $attributes = [])
    {
        $this->table = self::$_table;

        // Document fields
        $this->fieldModelInfo = new ModelHelper();
        $this->fieldModelInfo->increments('id');
        $this->fieldModelInfo->text('label');
        $this->fieldModelInfo->double('size');
        $this->fieldModelInfo->text('path');
        $this->fieldModelInfo->text('type');

        $this->fieldModelInfo->integer('id_opportunity', false, true)->default(0);
        $this->fieldModelInfo->integer('id_user_account_manager', false, true)->default(0);

        $this->fieldModelInfo->timestamps();
        $this->fieldModelInfo->softDeletes();

        parent::__construct($attributes);
    }

    public static function getSchema()
    {
        return $schema = Capsule::schema()->getColumnListing(self::$_table) ;
    }

    public function save(array $options = [])
    {

        // to delete unwanted field
        $schema = self::getSchema();
        foreach ($this->getAttributes() as $key => $value) {
            if (!in_array($key, $schema)) {
                //echo $key . "\n" ;
                unset($this->$key);
            }
        }
        // end to delete unwanted field

        return parent::save($options);
    }
}