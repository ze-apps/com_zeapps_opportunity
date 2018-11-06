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

    private function upload()
    {
        $errors = array();
        $uploadedFiles = array();
        $extension = array("jpeg","jpg","png","gif");
        $bytes = 1024;
        $KB = 1024;
        $totalBytes = $bytes * $KB;
        $UploadFolder = "/uploads";

        $counter = 0;

        foreach($_FILES["files"]["tmp_name"] as $key => $tmp_name) {

            $temp = $_FILES["files"]["tmp_name"][$key];
            $name = $_FILES["files"]["name"][$key];

            if (empty($temp)) {
                break;
            }

            $counter++;
            $UploadOk = true;

            if($_FILES["files"]["size"][$key] > $totalBytes) {
                $UploadOk = false;
                array_push($errors, $name." La taille du fichier est supérieure à 1M.");
            }

            $ext = pathinfo($name, PATHINFO_EXTENSION);
            if(in_array($ext, $extension) == false){
                $UploadOk = false;
                array_push($errors, $name." est un type de fichier invalide.");
            }

            if(file_exists($UploadFolder."/".$name) == true){
                $UploadOk = false;
                array_push($errors, $name." fichier déjà existant.");
            }

            if($UploadOk == true){
                move_uploaded_file($temp,$UploadFolder."/".$name);
                array_push($uploadedFiles, $name);
            }
        }

        /*if ($counter>0) {
            if (count($errors)>0)
            {
                echo "<b>Erreurs : </b>";
                echo "<br/><ul>";
                foreach($errors as $error)
                {
                    echo "<li>".$error."</li>";
                }
                echo "</ul><br/>";
            }

            if (count($uploadedFiles)>0) {
                echo "<b>Fichiers chargés : </b>";
                echo "<br/><ul>";
                foreach($uploadedFiles as $fileName) {
                    echo "<li>".$fileName."</li>";
                }
                echo "</ul><br/>";

                echo count($uploadedFiles)." fichier(s) ont été chargés correctement.";
            }
        } else {
            echo "Merci de sélectionner le(s) fichier(s) à charger.";
        }*/
    }

    public function save()
    {
        var_dump('t dans la bonne methode');



        // constitution du tableau
        $data = array() ;

        if (strcasecmp($_SERVER['REQUEST_METHOD'], 'post') === 0 && stripos($_SERVER['CONTENT_TYPE'], 'application/json') !== FALSE) {
            // POST is actually in json format, do an internal translation
            $data = json_decode(file_get_contents('php://input'), true);
        }

        /*$document = new Document() ;

        foreach ($data as $key => $value) {
            $document->$key = $value;
        }

        $document->save();*/

        $this->upload();

        echo 44;
        //echo $document->id;
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