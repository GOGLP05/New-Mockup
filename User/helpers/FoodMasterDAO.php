<?php
require_once 'DAO.php';
class FoodMasterDAO 
{
    public function get_foods() { 
        $dbh = DAO::get_db_connect(); 
         $sql = "SELECT * FROM food_master";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = []; 
        while($row = $stmt->fetchObject('FoodMasterDAO')){
            $data[] = $row;
        } 
        return $data; 
    } 
    //いらない？？
    public function get_name_and_path() {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT food_name, food_file_path FROM food_master";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];
        while($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        } 
        return $data; 
    }



}
