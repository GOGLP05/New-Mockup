<?php
$pdo = new PDO('mysql:dbname=23jn03_G05;host=WIN-AR2HAH01KUE\SOTSU;' , 'ユーザー名', 'パスワード');
$pdo->query('SET NAMES utf8;');

// 2.実行したいSQL文をセットする。
$stmt = $pdo->prepare('SELECT * FROM user WHERE mail_address = :mail_address LIMIT 1');

// 3.SQLに対してパラメーターをセットする。【任意】
$stmt->bindValue(':mail_address', $mail_address, PDO::PARAM_STR);

// 4.実際にSQLを実行する。
$stmt->execute();

// 5.結果を取得する。【任意】
$user = $stmt->fetch();

// 6.データーベースから切断する。
unset($pdo);