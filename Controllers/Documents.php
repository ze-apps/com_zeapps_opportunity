<?php

namespace App\com_zeapps_opportunity\Controllers;

use App\com_zeapps_opportunity\Models\Document;
use App\com_zeapps_opportunity\Models\Note;

use Zeapps\Core\Controller;
use Zeapps\Core\Request;

class Documents extends Controller
{
    private $tmp_files;

    public function getAll(Request $request)
    {
        $id_opportunity = $request->input('id_opportunity', 0);
        $id_user_account_manager = $request->input('id_user_account_manager', 0);

        $documents = array();

        if ($id_opportunity > 0 && $id_user_account_manager > 0) {
            $documents = Document::where("id_opportunity", $id_opportunity)->where('id_user_account_manager', $id_user_account_manager)->orderBy('id', 'DESC')->get() ;
        }

        // Formatage des tailles pour l'affichage
        if (count($documents)) {

            foreach ($documents as $doc) {
                $doc->size = str_replace('.00', '', $this->human_filesize($doc->size));
            }

        }

        echo json_encode(array('documents' => $documents));
    }

    public function context()
    {
        if(!$documents = Document::orderBy('id', 'DESC')->get()) {
            $documents = array();
        }

        echo json_encode(array('documents' => $documents));
    }

    public function save()
    {
        $ind = 0;

        while (isset($_FILES['file'.$ind]['name']) && $_FILES['file'.$ind]['name']) {

            $tmpname = $_FILES['file'.$ind]['tmp_name'];
            $filename = $_FILES['file'.$ind]['name'];
            $filesize = $_FILES['file'.$ind]['size'];
            $filepath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
            $filetype = $_FILES['file'.$ind]['type'];

            // Save file to DB
            if (!is_file($filepath . $filename)) {

                $document = new Document();
                $document->label = $filename;
                $document->size = $filesize;
                $document->path = $filepath;
                $document->type = $filetype;

                $document->id_opportunity = 2;
                $document->id_user_account_manager = 1;

                $document->save();

                // Upload file
                move_uploaded_file($tmpname,$filepath . $filename);
            }

            $ind++;
        }

    }

    public function delete(Request $request)
    {
        $id = $request->input('id', 0);
        echo json_encode(Document::where('id', $id)->delete());
    }

    private function human_filesize($bytes, $decimals = 2) {
        $size = array(' Octets',' Mo',' Go',' To',' Po',' Eo',' Zo',' Yo');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

}