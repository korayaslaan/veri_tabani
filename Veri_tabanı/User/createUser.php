<?phpinclude "../class.php";header("Access-Control-Allow-Origin: *");header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");if(isset($_GET["key"])){    $postdata = file_get_contents("php://input");    if(isset($postdata)){        $request = json_decode($postdata);        $firstname = $request->firstname;        $lastname = $request->lastname;        $email = $request->email;        $phone = $request->phone;        $password = $request->password;$user = new User();            echo json_encode($user->createUser($firstname,$lastname,$email,$phone,$password), JSON_UNESCAPED_UNICODE); } else {     $result["result"] = false;     $result["code"] = 2002;     $result["data"] ="error post data";     echo json_encode($result, JSON_UNESCAPED_UNICODE); }  }  else {     $result["result"] = false;     $result["code"] = 3003;     $result["data"] ="error key value";     echo json_encode($result, JSON_UNESCAPED_UNICODE); }            