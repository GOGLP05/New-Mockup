<?php
require_once 'DAO.php';

class Member {
    public int $member_id;
    public string $password; // Hashed password
    public int $sex;  // 性別を数値（1または0）で保存
    public string $birthdate; // Date format for consistency
    public string $email;
    public int $message;  // メッセージの値（デフォルトで0）
}

class MemberDAO {
    // メンバーを認証するメソッド
    public function get_member(string $email, string $password) {
        $dbh = DAO::get_db_connect();

        $sql = "SELECT * FROM member WHERE email = :email";
        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception('Failed to execute the query.');
        }

        $member = $stmt->fetchObject('Member');

        // パスワードの照合
        if ($member !== false && password_verify($password, $member->password)) {
            return $member;
        }

        return false;
    }

    public function get_member_email() {
        $dbh = DAO::get_db_connect();
    
        $sql = "SELECT email FROM member";  // Complete the SQL query
    
        $stmt = $dbh->prepare($sql);
    
        if (!$stmt->execute()) {
            throw new Exception('Failed to execute the query.');
        }
    
        // Use fetchAll to retrieve all rows
        $member_emails = $stmt->fetchAll(PDO::FETCH_OBJ);
    
        return $member_emails; // Return the array of results
    }

    public function update_password_by_email($email, $new_password) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "UPDATE member SET password = :password WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':password', $new_password, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);

            // パスワード更新処理が成功すれば true を返す
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }
    
    public function get_notification($email) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "SELECT message FROM member WHERE email = :email";  // emailに基づいてmessage（通知設定）を取得
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return (int) $result['message'];  // notification設定（0または1）を返す
            } else {
                // 該当するメールアドレスが見つからない場合はデフォルトの0を返す
                return 0;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

        public function update_notification($email, $notification) {
            try {
                $dbh = DAO::get_db_connect();
                $sql = "UPDATE member SET message = :message WHERE email = :email";
                $stmt = $dbh->prepare($sql);
                $stmt->bindParam(':message', $notification, PDO::PARAM_INT);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->rowCount() > 0; // 更新された行数が0より大きければ成功
            } catch (PDOException $e) {
                throw new Exception('データベースの更新に失敗しました: ' . $e->getMessage());
            }
        }
    
    
    
    


    // 新しいメンバーを登録するメソッド
    public function create_member($email, $password, $sex, $birthdate) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "INSERT INTO member (email, password, sex, birthdate) VALUES (:email, :password, :sex, :birthdate)";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password, PDO::PARAM_STR);
            $stmt->bindValue(':sex', $sex, PDO::PARAM_INT);  // 性別を数値で保存
            $stmt->bindValue(':birthdate', $birthdate, PDO::PARAM_STR);  // 生年月日を文字列で保存
            
            // message 列はデフォルトで 0 なので、明示的に指定する必要はない
            if ($stmt->execute()) {
                return true;  // 成功
            } else {
                return false;  // 失敗
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // メールアドレスが既に登録されているか確認
    public function email_exists($email) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "SELECT COUNT(*) FROM member WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // メンバーIDでユーザー情報を取得
    public function get_member_by_id($member_id) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM member WHERE member_id = :member_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchObject('Member');
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // パスワードを更新
    public function update_password($member_id, $new_password) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "UPDATE member SET password = :password WHERE member_id = :member_id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':password', $new_password, PDO::PARAM_STR);
            $stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // メンバーの通知設定を更新するメソッド
    public function update_message($email, $message) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "UPDATE member SET message = :message WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':message', $message, PDO::PARAM_INT); // 変更するmessageの値
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);  // 更新するメールアドレス

            return $stmt->execute();  // 実行して成功したかどうかを返す
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }

    // メールアドレスからメンバー情報を取得するメソッド
    public function get_member_by_email($email) {
        try {
            $dbh = DAO::get_db_connect();
            $sql = "SELECT * FROM member WHERE email = :email";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $member = $stmt->fetchObject('Member');
            return $member;  // メンバーオブジェクトを返す
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new Exception('データベースエラー');
        }
    }
}
?>
