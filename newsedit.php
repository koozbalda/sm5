<?php
session_start();
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 16:20
 */

require_once ("config.php");

if(!empty($_GET['news_id'])){
    $query="SELECT * from `news` WHERE `news_id`= '{$_GET['news_id']}'";
    $res=mysqli_query($connect,$query)->fetch_assoc();

}
?>
    <head>
        <link rel="stylesheet" href="bootstrap.css">
    </head>
    <form class="form-horizontal" action="/checkNews.php" method="post">
<?php

foreach($res as $key=>$value){
    echo "<div>";

    if(strlen($value)>25){
        echo "<label><textarea class='form-horizontal'  name='{$key}'  required>{$value}</textarea>{$key}</label> <br/>";
    }else{

        echo "<label><input class='form-horizontal' type='text' name='{$key}' value='{$value}' required>{$key}</label> <br/>";
    }
    echo "</div>";
}

echo " <input name='editNews' type=\"submit\" value=\"edit\"/><br/>";
