<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    if(isset($postdata)){
        $request = json_decode($postdata);

        $admin_id = $request->admin_id;
        $admin_token = $request->admin_token;

        
        $admin = new Admin();
        echo json_encode($admin->checkToken($admin_id,$admin_token), JSON_UNESCAPED_UNICODE);
    }
    else{
        echo '{"sonuc" : "hatalı"}';
    }
   
}

?>