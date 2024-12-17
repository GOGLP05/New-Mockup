<?php
 require_once 'DAO.php';

class Member{
    public int $member_id;
    public  $password;
    public bool $sex;
    public int $birthdate;
    public string $email;
    public bool $message;
}

    class member_DAO 
    {
        public function get_members() { 
            $dbh = DAO::get_db_connect(); 
            $sql = "SELECT * FROM member";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = []; 
            while($row = $stmt->fetchObject('Member')){
                $data[] = $row;
            } 
            return $data; 
        } 
    }