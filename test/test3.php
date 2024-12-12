<?php
// DB接続設定の読み込み
require_once 'test2.php';

class FoodMaster{
    public int $food_id;
    public string $food_name;
}

class Food_MasterDAO{
   
    public function get_foodmaster()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT food_id, food_name FROM food_master";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('food_master')){
            $data[] = $row;
        }

        return $data;
    }
}