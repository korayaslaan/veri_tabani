<?php
include "../class.php";
header("Access-Control-Allow-Origin: *");      
header("Access-Control-Allow-Headers:
{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
if(isset($_GET["key"])){
    $postdata = file_get_contents("php://input");

    if(isset($postdata)){
        $request = json_decode($postdata);
        $team_id = $request->id;
        $name = $request->name;
        $position = $request->position;
        $about = $request->about;
        $facebook = $request->facebook;
        $instagram = $request->instagram;
        $twitter = $request->twitter;
        $whatsapp = $request->whatsapp;
        $youtube = $request->youtube;
        $linkedin = $request->linkedin;
        $phone = $request->phone;
        $whatsapp = $request->whatsapp;
        $img_url = $request->img_url;


        if (!empty($request->user_id) && !empty($request->user_token)) {
            $user_id = $request->user_id;
            $user_token = $request->user_token;
            
            $team = new Team();
            echo json_encode($team->updateTeam($team_id,$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url,$user_id, null, $user_token, null), JSON_UNESCAPED_UNICODE);
    } else if (!empty($request->admin_id) && !empty($request->admin_token)) {
            $admin_id = $request->admin_id;
            $admin_token = $request->admin_token;
            
            $team = new Team();
            echo json_encode($team->updateTeam($team_id,$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url,null, $admin_id, null, $admin_token), JSON_UNESCAPED_UNICODE);
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
    

    