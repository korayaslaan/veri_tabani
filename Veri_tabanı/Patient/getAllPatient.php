<?php

include "../class.php";


if (isset($_GET["key"])) {

        $postdata = file_get_contents("php://input");

        if (isset($postdata)) {

                $request = json_decode($postdata);
                        $patient = new Patient();

                        echo json_encode($patient->getAllPatient(), JSON_UNESCAPED_UNICODE);

        } else {

                $result["result"] = false;

                $result["code"] = 2002;

                $result["data"] = "error post data";

                echo json_encode($result, JSON_UNESCAPED_UNICODE);

        }

} else {

        $result["result"] = false;

        $result["code"] = 3003;

        $result["data"] = "error key value";

        echo json_encode($result, JSON_UNESCAPED_UNICODE);

}

