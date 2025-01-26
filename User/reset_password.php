<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $serverName = "localhost";
    $connectionOptions = [
        "Database" => "OtpSystem",
        "Uid" => "your_username",
        "PWD" => "your_password"
    ];
    $conn = sqlsrv_connect($serverName, $connectionOptions);

    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // メールアドレスから member_id を取得
    $query = "SELECT member_id FROM member WHERE email = ?";
    $stmt = sqlsrv_query($conn, $query, [$email]);
    $member = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$member) {
        die("指定されたメールアドレスは登録されていません。");
    }

    $memberId = $member['member_id'];

    // OTPの検証
    $query = "SELECT * FROM otp_requests WHERE member_id = ? AND otp = ? AND expires_at > GETDATE()";
    $stmt = sqlsrv_query($conn, $query, [$memberId, $otp]);
    $otpRecord = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if (!$otpRecord) {
        die("無効なまたは期限切れのワンタイムパスコードです。");
    }

    // パスワードリセット画面へリダイレクト
    header("Location: new_password.php?member_id=$memberId");
    exit();
}
?>
