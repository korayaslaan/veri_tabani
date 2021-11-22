<?php

include "../class.php";



if(isset($_GET["key"])){

    $postdata = file_get_contents("php://input");



    if(isset($postdata)){

        $request = json_decode($postdata);

        $id = $request->id;

        $hasta_id = $request->hasta_id;

        $ucret_id = $request->ucret_id;

        $doktor_id = $request->doktor_id;

        $aciklama = $request->aciklama;

        $bakiye_id = $request->bakiye_id;

            $records = new Patientrecords();

            echo json_encode($records->updatePatientrecords($id,$hasta_id, $ucret_id, $doktor_id, $aciklama, $bakiye_id), JSON_UNESCAPED_UNICODE);


 } else {

     $result["result"] = false;

     $result["code"] = 2002;

     $result["data"] ="error post data";

     echo json_encode($result, JSON_UNESCAPED_UNICODE);

 }

 

 } 

 else {

     $result["result"] = false;

     $result["code"] = 3003;

     $result["data"] ="error key value";

     echo json_encode($result, JSON_UNESCAPED_UNICODE);

 }

    



    