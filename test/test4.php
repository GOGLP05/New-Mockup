<?php
require_once 'test/test3.php';

$test3 = new test3();
$food_list = $test3->get_foodmaster();
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
        <?php foreach($food_list as $food_master) : ?>
            <tr>
                <td>
                    <?=$food_list->$food_name ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>