<?php
require_once 'DAO.php';
class foodMaster{
    public int $food_id;
    public string $food_name;
    public string $expiry_date;
    public string $category_id;
    public string $category_name;
    public string $standard_gram;
    public string $food_file_path;
}


class FoodMasterDAO 
{
    
    public function get_foods() { 
        $dbh = DAO::get_db_connect(); 
         $sql = "SELECT * FROM food_master";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = []; 
        while($row = $stmt->fetchObject('foodMaster')){
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
        while($row = $stmt->fetchObject('foodMaster')) {
            $data[] = $row;
        } 
        return $data; 
    }

    public function get_use_unit() {
        $dbh = DAO::get_db_connect();
        $sql = "SELECT food_name, food_file_path FROM food_master";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = [];
        while($row = $stmt->fetchObject('foodMaster')) {
            $data[] = $row;
        } 
        return $data; 
    }

    public function get_name_and_path_paginated($page = 1, $perPage = 50) {

        $offset = ($page - 1) * $perPage;
        $sql = "SELECT food_name, food_file_path FROM food_master 
                ORDER BY food_name 
                OFFSET :offset ROWS FETCH NEXT :limit ROWS ONLY";


        $dbh = DAO::get_db_connect();
        $stmt = $dbh->prepare($sql);


        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);


        $stmt->execute();


        $data = [];
        while ($row = $stmt->fetchObject('FoodMaster')) {
            $data[] = $row;
        }

        return $data;
    }

    public function get_name_and_path_sort_by_registration_date($page = 1, $perPage = 50) {

//登録された順で表示
    }




}