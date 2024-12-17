<?php
try {
    $pdo = new PDO('mysql:dbname=23jn03_G05;host=10.32.97.1\Web;database=23jn0344;', '23jn0344', '23jn0344');
    $pdo->query('SET NAMES utf8;');

    $stmt = $pdo->prepare('SELECT * FROM user WHERE mail_address = :mail_address LIMIT 1');
    $stmt->bindValue(':mail_address', $mail_address, PDO::PARAM_STR);
    $stmt->execute();

    $user = $stmt->fetch();

    unset($pdo);
} catch (PDOException $e) {
    echo 'Database Error: ' . $e->getMessage();
}
