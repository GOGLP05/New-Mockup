<?php
    require_once 'Member_DAO.php';

    $Member_DAO = new Member_DAO();

    $member_list = $Member_DAO->get_members();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバー一覧</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>会員ID</th>
            <th>メールアドレス</th>
            <th>パスワード</th>
            <th>性別</th>
            <th>生年月日</th>
            <th>通知</th>
        </tr>
        <?php foreach ($member_list as $member) : ?>
            <tr>
                <td><?= htmlspecialchars($member->member_id, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->email, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->password, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->sex, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->birthdate, ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($member->message, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    
</body>
</html>
