<?php
class Config
{
    private $databaseHost = 'localhost';
    private $databaseName = 'proje';
    private $databaseUsername = 'root';
    private $databasePassword = '';

    function db()
    {
        try {
            $mysql_connection = "mysql:host=$this->databaseHost;dbname=$this->databaseName";
            $dbconnection = new PDO($mysql_connection, $this->databaseUsername, $this->databasePassword);
            $dbconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbconnection;
        } catch (PDOException $e) {
            //echo "Bağlantı Hatası: " . $e->getMessage() . "<br/>";
        }
    }
}



class Crud extends Config
{
    function delete($sql)
    {
        $db = $this->db();
        $sql=$db->exec($sql);
        return $sql;
    }

    function insertAndUpdate($sql,$data){
        $db = $this->db();
        $sql=$db->prepare($sql);
        $sql->execute($data);
        $return = true;
        return $return;
    }

    function get($sql){
  
        try {

            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetch(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;


        } catch (PDOException $ex) {
            return $ex;
        }
    }

    function getAll($sql){
        try {
            $db = $this->db();
            $query = $db->query($sql);
            $data = $query->fetchAll(PDO::FETCH_OBJ); #PDO::FETCH_ASSOC
            $db=null;
            $return = false;
            
            if(!empty($data)){

                $return = $data;
            }

            return $return;

        } catch (PDOException $ex) {
            return $ex;
        }

    }

    function checkAccessForAdmin($admin_id,$admin_token){
        $result=false;


            if($admin_id != null && $admin_token != null){
                $result =$this->checkTokenForAdmin($admin_id,$admin_token);

            }

        return $result;
    }

    function checkTokenForAdmin($id,$token){
        $sql = "Select id from admins WHERE id='$id' AND token = '$token' ";
        $result=$this->get($sql);
        $return=false;
        if($result){
            $return=true;
        }

        return $return;
    }

    
}

class Admin extends Crud
{

    function createAdmin($firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $token=md5(uniqid(rand(), true));
            $password=md5($password);
        $sql="INSERT INTO admins (firstname,lastname,email,token,phone,password) VALUES (?,?,?,?,?,?)";
        $data=[$firstname,$lastname,$email,$token,$phone,$password];
        $result["result"] = $this->insertAndUpdate($sql,$data);

        }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }

        return $result;
    }

    function deleteByMyIdAdmin($admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM admins WHERE id = '$admin_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }


    function deleteByIdAdmin($delete_id,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM admins WHERE id = '$delete_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }



    function getByIdAdmin($get_id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from admins WHERE id='$get_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByMyIdAdmin($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from admins WHERE id='$admin_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;

    }

    function getAllAdmin($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "Select * from admins";
        $result["data"]=$this->getAll($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function updateByMyIdAdmin($firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $password=md5($password);
        $sql = "UPDATE admins SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$admin_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }

        return $result;
    }

    function updateByIdAdmin($update_id,$firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $password=md5($password);

        $sql = "UPDATE admins SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$update_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }

        return $result;
    }

    function login($email, $password)
    {
        $password=md5($password);
        $sql = "Select id from admins WHERE email='$email' AND password='$password' ";
        $result["data"]=$this->get($sql);


        if($result["data"]){

            $array_result = json_decode(json_encode($result), true);
            $id= $array_result["data"]["id"];

            $token=md5(uniqid(rand(), true));
            $result["token"]= $token;
            $sql = "UPDATE admins SET token = ? WHERE id = '$id' ";
            
            $data = [$token];
            $result["result"]=$this->insertAndUpdate($sql,$data);
            
        }
       
        return $result;
    }
    
    function checkToken($admin_id, $admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);
        
        return $result;
    }
    

}

class User extends Crud
{
    function createUser($firstname,$lastname,$email,$phone,$password)
    {
       
      
            $token=md5(uniqid(rand(), true));
            $password=md5($password);
        $sql="INSERT INTO users (firstname,lastname,email,phone,password,token,is_activation) VALUES (?,?,?,?,?,?,?)";
        $data=[$firstname,$lastname,$email,$phone,$password,$token,0];
        $result["result"] = $this->insertAndUpdate($sql,$data);


        $activation_code=md5(uniqid(rand(), true));
        $sql="INSERT INTO activation (email,activation_code) VALUES (?,?)";
        $data=[$email,$activation_code];
        $result["result"] = $this->insertAndUpdate($sql,$data);
     
       
        
        return $result;
    }

  

    function deleteByMyIdUser($user_id,$admin_id,$user_token,$admin_token)
    {

        $sql = "DELETE FROM users WHERE id = '$user_id'";
        $result["data"] = $this->delete($sql);

    
        return $result;
    }


    function deleteByIdUser($delete_id,$admin_id,$admin_token)
    {

        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql = "DELETE FROM users WHERE id = '$delete_id'";
        $result["data"] = $this->delete($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }



    function getByIdUser($get_id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $sql = "Select * from users WHERE id='$get_id' ";
            $result["data"]=$this->get($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function getByMyIdUser($user_id,$admin_id,$user_token,$admin_token)
    {
     
            $sql = "Select * from users WHERE id='$user_id' ";
            $result["data"]=$this->get($sql);

    
        return $result;

    }

    function getAllUser($admin_id,$admin_token)
    {
      
        $sql = "Select * from users";
        $result["data"]=$this->getAll($sql);

     
        return $result;
    }

    function updateByMyIdUser($firstname,$lastname,$email,$phone,$password,$user_id,$admin_id,$user_token,$admin_token)
    {
    
            $password=md5($password);
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$user_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

     
        return $result;
    }

    function updateByIdUser($update_id,$firstname,$lastname,$email,$phone,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            
            $password=md5($password);
        $sql = "UPDATE users SET firstname = ?, lastname = ?, email = ?, phone = ?, password = ? WHERE id = '$update_id'";
        $data = [$firstname,$lastname,$email,$phone,$password];

        $result["data"] = $this->insertAndUpdate($sql,$data);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function login($email, $password)
    {
        $password=md5($password);
        $sql = "Select * from users WHERE email='$email' AND password='$password' ";
        $result["data"]=$this->get($sql);


        if($result["data"]){

            $array_result = json_decode(json_encode($result), true);
            $id= $array_result["data"]["id"];

            $token=md5(uniqid(rand(), true));
            $result["token"]= $token;
            $sql = "UPDATE users SET token = ? WHERE id = '$id' ";
            
            $data = [$token];
            $result["result"]=$this->insertAndUpdate($sql,$data);
            
        }

        return $result;
    }
}

class Staff extends Crud
{
    function createStaff($name, $position, $tel, $email, $tc_number, $department, $duty ,$admin_id, $admin_token)
    {
    
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO calisanlar (name, position, tel, email, tc_number, department, duty) VALUES (?,?,?,?,?,?,?)";
        $data=[$name, $position, $tel, $email, $tc_number, $department, $duty ];
        $result["result"] = $this->insertAndUpdate($sql,$data);

    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }
   
        return $result;

    }
    
    function deleteTeam($team_id,$user_id,$admin_id,$user_token,$admin_token)
    {
     
        $sql = "DELETE FROM team WHERE id = '$team_id'";
        $result["data"] = $this->delete($sql);
      
        return $result;
    }
    function updateTeam($team_id,$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url,$user_id,$admin_id,$user_token,$admin_token)
    {
      
        $sql = "UPDATE team SET name = ?, position = ?, about = ?, facebook = ?, instagram = ?, twitter = ?, whatsapp = ?, youtube = ?, linkedin = ?, phone = ?, img_url = ? WHERE id = '$team_id'";
        $data = [$name,$position,$about,$facebook,$instagram,$twitter,$whatsapp,$youtube,$linkedin,$phone,$img_url];
        $result["data"] = $this->insertAndUpdate($sql,$data);
      

        return $result;
    }

    function getByIdTeam($team_id)
    {

        $sql = "Select * from team WHERE id='$team_id' ";
        $result["data"]=$this->get($sql);
    
    return $result;

    }

    function getAllTeam()
    {

        $sql = "Select * from team ";
        $result["data"]=$this->getAll($sql);
        return $result;

    }

}