<?php

namespace App\com_zeapps_opportunity\Controllers;

use App\com_zeapps_opportunity\Models\Note;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;

class Notes extends Controller
{
    public function getAll()
    {
        if(!$notes = Note::orderBy('id', 'DESC')->limit(4)->get()) {
            $notes = array();
        }

        echo json_encode(array('notes' => $notes));
    }

    public function context()
    {
        if(!$notes = Note::orderBy('id', 'DESC')->limit(4)->get()) {
            $notes = array();
        }

        echo json_encode(array('notes' => $notes));
    }

    public function save()
    {
        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        $note = new Note() ;

        if (isset($data["id"]) && is_numeric($data["id"])) {
            $note = Note::where('id', $data["id"])->first() ;
        }

        foreach ($data as $key =>$value) {
            $note->$key = $value ;
        }

        $note->save();

        echo $note->id;
    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);

        echo json_encode(Note::where('id', $id)->delete());
    }

}