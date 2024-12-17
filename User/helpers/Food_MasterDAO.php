<?php
 require_once 'DAO.php';

class Food_Master{
    public int $food_id;
    public string $food_name;
    public int $expiry_date;
    public $food_file_path;
    public $category_id;
    public $standard_gram;
}

    class food_masterDAO 
    { 
        public function get_foods() { 
            $dbh = DAO::get_db_connect(); 
            $sql = "SELECT * FROM food_master";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = []; 
            while($row = $stmt->fetchObject('Food_Master')){
                $data[] = $row;
            } 
            return $data; 
        } 
    }