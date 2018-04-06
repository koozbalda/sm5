<?php
session_start();
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 16:20
 */

require_once("config.php");

//если это запрос на изменение записи, взять все данные для этой таблицы
if (!empty($_GET['news_id'])) {
    $query1 = "SELECT * from `news` WHERE `news_id`= '{$_GET['news_id']}'";
    $res1 = mysqli_query($connect, $query1)->fetch_assoc();
}

//узнать какие есть столбцы в БД и какие у них свойства
$query = "SHOW COLUMNS FROM news";

$res = mysqli_query($connect, $query);
?>


    <head>
        <link rel="stylesheet" href="bootstrap.css">
    </head>
    <form class="form-horizontal" action="/checkNews.php" method="post">


<?php


foreach ($res as $key => $value) {
    if ($value['Extra'] != 'auto_increment') {
        $v = !empty($res1[$value['Field']]) ? $res1[$value['Field']] : '';
        echo "<div>";

//если поле ключ на другую таблицу
        if ($value['Key']=='MUL') {

            $q = "SELECT `REFERENCED_TABLE_NAME` FROM `REFERENTIAL_CONSTRAINTS` WHERE `CONSTRAINT_SCHEMA` = '" . DATABASE . "' AND `TABLE_NAME` = 'news' ";
            $r2d2 = $infoConnect->query($q)->fetch_assoc();
            $q2="SELECT category_id, category_name  from `".$r2d2['REFERENCED_TABLE_NAME']."` ";
            $data=mysqli_query($connect,$q2);

            echo "<label><select style='width: 400px' class='form-horizontal' name='{$value['Field']}' required>";

            foreach($data as $value){
                echo " <option value='{$value['category_id']}'> {$value['category_name']}</option>";
            }

             echo "</select>
                    {$value['Field']}</label> <br/>";

        } else {
            if ($value['Type'] == 'text') {
                echo "<label><textarea style='width: 400px'  class='form-horizontal'  name='{$value['Field']}'  required>{$v}</textarea>{$value['Field']}</label> <br/>";
            } else {

                echo "<label><input style='width: 400px' class='form-horizontal' type='text' name='{$value['Field']}' value='{$v}' required>{$value['Field']}</label> <br/>";
            }
            echo "</div>";
        }
    }
}




if ($_POST['createNews'] == 'true') {

    echo " <input class='btn btn-success' name='createNews' type=\"submit\" value=\"create\"/>";
} else {

    echo " <input class='btn btn-primary' name='editNews' type=\"submit\" value=\"edit\"/>";
}
echo " <a class='btn btn-primary' href='{$_SERVER['HTTP_REFERER']}' name='Return'>Return</a>";