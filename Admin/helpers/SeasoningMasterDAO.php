<?php
 require_once 'DAO.php';

class SeasoningMaster{
    public int $seasoning_id;
    public string $seasoning_name;
    public string $unit;
}

    class SeasoningMasterDAO
    {
        public function get_seasonings() { 
            $dbh = DAO::get_db_connect(); 
            $sql = "SELECT * FROM seasoning_master";
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data = []; 
            while($row = $stmt->fetchObject('seasoningMaster')){
                $data[] = $row;
            } 
            return $data; 
            
        } 
    }