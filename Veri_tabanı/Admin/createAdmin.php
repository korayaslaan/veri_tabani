<?php

include "../class.php";

if(isset($_GET["key"])){

    $postdata = file_get_contents("php://input");



    if(isset($postdata)){

        $request = json_decode($postdata);



        $name = $request->name;

        $surname = $request->surname;

        $tel = $request->tel;

        $email = $request->email;

        $password = $request->password;



        if (!empty($request->admin_id) && !empty($request->admin_token)) {

            $admin_id = $request->admin_id;

            $admin_token = $request->admin_token;

            

            $admin = new Admin();

            echo json_encode($admin->createAdmin($name,$surname,$tel,$email,$password,$admin_id, $admin_token), JSON_UNESCAPED_UNICODE);

    } else {

           $result["result"] = false;

           $result["code"] = 1001;

           $result["data"] ="access denied";

           echo json_encode($result, JSON_UNESCAPED_UNICODE);

    }

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

    



    