<?php
 require_once 'DAO.php';

class Category{
    public int $category_id;
    public  $category_name;
    public bool $use_unit;
}

    class categoryDAO 
    {
        public function get_categories() { 
            $dbh = DAO::get_db_connect(); 
            $sql = "SELECT * FROM category";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = []; 
            while($row = $stmt->fetchObject('Category')){
                $data[] = $row;
            } 
            return $data; 
        } 
    }