<?php

include "../class.php";



if(isset($_GET["key"])){

    $postdata = file_get_contents("php://input");



    if(isset($postdata)){

        $request = json_decode($postdata);

        $id = $request->id;

        $name = $request->name;

        $surname = $request->surname;

        $tel = $request->tel;

        $email = $request->email;

        $tc_number = $request->tc_number;

        $date_birth = $request->date_birth;


            $patient = new Patient();

            echo json_encode($patient->updatePatient($id,$name, $surname, $tel, $email, $tc_number, $date_birth), JSON_UNESCAPED_UNICODE);


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

    



    