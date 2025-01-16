<?php
 require_once 'DAO.php';

class Member{
    public int $member_id;
    public  string $password;
    public int $sex;
    public string $birthdate;
    public string $email;
    public string $message;
}

    class Member_DAO
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

        public function delete(int $member_id) {
            $dbh = DAO::get_db_connect();
        
            // SQL文
            $sql = "DELETE FROM member WHERE member_id = :member_id";
            $stmt = $dbh->prepare($sql);
        
            // パラメータをバインド
            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
        
            // 削除実行後、影響を受けた行数を確認
            $stmt->execute();
            
            // 行数が1以上であれば削除成功、それ以外は失敗
            return $stmt->rowCount() > 0;
        }
            }