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
        $sql = "Select id from kullanıcılar WHERE id='$id' AND token = '$token' ";
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

    function createAdmin($name,$surname,$tel,$email,$password,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
            $token=md5(uniqid(rand(), true));
            $password=md5($password);
        $sql="INSERT INTO kullanıcılar (name,surname,tel,email,password,token) VALUES (?,?,?,?,?,?)";
        $data=[$name,$surname,$tel,$email,$password,$token];
        $result["result"] = $this->insertAndUpdate($sql,$data);

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
        $sql = "DELETE FROM kullanıcılar WHERE id = '$delete_id'";
        $result["data"] = $this->delete($sql);

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
        $sql = "Select * from kullanıcılar";
        $result["data"]=$this->getAll($sql);

        }
        else{
            $result["result"] = false;
            $result["code"] = 4004;
            $result["data"] ="error wrong token or id";
        }
        return $result;
    }

    function checkToken($admin_id, $admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token); //checkAccessForAdmin  METODUNUDA SS LE
        
        return $result;
    }





    function login($email, $password)
    {
        $password=md5($password);
        $sql = "Select id from admins WHERE email='$email' AND password='$password' ";
        $result["data"]=$this->get($sql);  

        // ŞİMDİLİK BURAYI YAZMA RAPORA BUNU ÖNÜMÜZDEKİ HAFTA EKLEYECEĞİZ

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
    function createStaff($name,$surname, $tel, $email, $tc_number, $department, $duty, $wage ,$admin_id, $admin_token)
    {
    
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
        $sql="INSERT INTO calisanlar (name, surname, tel, email, tc_number, department,duty, wage) VALUES (?,?,?,?,?,?,?,?)";
        $data=[$name,$surname, $tel, $email, $tc_number, $department,$duty, $wage ];
        $result["result"] = $this->insertAndUpdate($sql,$data);

    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }
   
        return $result;

    }
    
    function deleteStaff($id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
     
        $sql = "DELETE FROM calisanlar WHERE id = '$id'";
        $result["data"] = $this->delete($sql);

    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }
      
        return $result;
    }


    function updateStaff($id,$name,$surname, $tel, $email, $tc_number, $department, $duty, $wage ,$admin_id, $admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){
      
        $sql = "UPDATE calisanlar SET name = ?, surname = ?, tel = ?, email = ?, tc_number = ?, department = ?, duty = ?, wage = ? WHERE id = '$id'";
        $data = [$name,$surname, $tel, $email, $tc_number, $department, $duty, $wage];
        $result["data"] = $this->insertAndUpdate($sql,$data);
    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }

        return $result;
    }

    function getByIdStaff($id,$admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){

        $sql = "Select * from calisanlar WHERE id='$id' ";
        $result["data"]=$this->get($sql);
    
    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }
    return $result;

    }

    function getAllStaff($admin_id,$admin_token)
    {
        $result["result"]=false;

        $result["result"]= $this->checkAccessForAdmin($admin_id,$admin_token);

        if($result["result"] == true){

        $sql = "Select * from calisanlar ";
        $result["data"]=$this->getAll($sql);
    }
    else{
        $result["result"] = false;
        $result["code"] = 4004;
        $result["data"] ="error wrong token or id";
    }
        return $result;

    }

}
class Patient extends Crud
{
    function createPatient($name,$surname, $tel, $email, $tc_number, $date_birth)
    {
        $sql="INSERT INTO hasta_bilgileri (name, surname, tel, email, tc_number, date_birth) VALUES (?,?,?,?,?,?)";
        $data=[$name,$surname, $tel, $email, $tc_number, $date_birth ];
        $result["result"] = $this->insertAndUpdate($sql,$data);

        return $result;

    }
    
    function deletePatient($id)
    {
        $sql = "DELETE FROM hasta_bilgileri WHERE id = '$id'";
        $result["data"] = $this->delete($sql);

        return $result;
    }


    function updatePatient($id,$name,$surname, $tel, $email, $tc_number, $date_birth)
    {     
        $sql = "UPDATE hasta_bilgileri SET name = ?, surname = ?, tel = ?, email = ?, tc_number = ?, date_birth = ? WHERE id = '$id'";
        $data = [$name,$surname, $tel, $email, $tc_number, $date_birth];
        $result["data"] = $this->insertAndUpdate($sql,$data);

        return $result;
    }

    function getByIdPatient($id)
    {
        $sql = "Select * from hasta_bilgileri WHERE id='$id' ";
        $result["data"]=$this->get($sql);
 
    return $result;

    }

    function getAllPatient()
    {
        $sql = "Select * from hasta_bilgileri ";
        $result["data"]=$this->getAll($sql);

        return $result;

    }

}
class Patientrecords extends Crud
{
    function createPatientrecords($hasta_id, $ucret_id, $doktor_id, $aciklama, $bakiye_id)
    {
        $sql="INSERT INTO hasta_kayitlari (hasta_id, ucret_id, doktor_id, aciklama, bakiye_id) VALUES (?,?,?,?,?)";
        $data=[$hasta_id,$ucret_id, $doktor_id, $aciklama, $bakiye_id];
        $result["result"] = $this->insertAndUpdate($sql,$data);

        return $result;

    }
    
    function deletePatientrecords($id)
    {
        $sql = "DELETE FROM hasta_kayitlari WHERE id = '$id'";
        $result["data"] = $this->delete($sql);

        return $result;
    }


    function updatePatientrecords($id,$hasta_id, $ucret_id, $doktor_id, $aciklama, $bakiye_id)
    {     
        $sql = "UPDATE hasta_kayitlari SET hasta_id = ?, ucret_id = ?, doktor_id = ?, aciklama = ?, bakiye_id = ? WHERE id = '$id'";
        $data = [$hasta_id,$ucret_id, $doktor_id, $aciklama, $bakiye_id];
        $result["data"] = $this->insertAndUpdate($sql,$data);

        return $result;
    }

    function getByIdPatientrecords($id)
    {
        $sql = "Select * from hasta_kayitlari WHERE id='$id' ";
        $result["data"]=$this->get($sql);
 
    return $result;

    }

    function getAllPatientrecords()
    {
        $sql = "Select * from hasta_kayitlari ";
        $result["data"]=$this->getAll($sql);

        return $result;

    }

}