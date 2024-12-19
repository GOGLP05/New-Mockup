<?php
require_once 'test_adminDAO.php';

$adminDAO = new test_adminDAO();
$user_list = $adminDAO->get_admin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>foodmaster</title>
</head>
<body>
    <?php include 'header.php' ?>

    <table>
        <?php foreach($user_list as $admin) : ?>
            <tr>
                <td>
                    <?=$user_list->$user_id ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

DELETE