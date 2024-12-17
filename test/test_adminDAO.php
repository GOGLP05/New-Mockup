<?php
// DB接続設定の読み込み
require_once 'test_DAO.php';

class test_adminDAO{
    public int $user_id;

}

class adminDAO{

    public function get_admin()
    {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT admin_id FROM  dbo.admin";
        $stmt = $dbh->prepare($sql);

        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('test_adminDAO')){
            $data[] = $row;
        }

        return $data;
    }
}