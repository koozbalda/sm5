<?php
session_start();
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 14:59
 */

if(empty($_SESSION['success'])){
    header('Location: /login.php');
    exit();
}
require_once ("config.php");

$query="SELECT * from `reg_users` WHERE `login`='{$_SESSION['success']}'";

$mysqli=new mysqli(HOST,USER,PASSWORD,DATABASE);

?>

    <form class="form-horizontal" action="/checkRegData.php" method="post">
<?php

foreach($mysqli->query($query)->fetch_assoc() as $key=>$value){

//    echo $key." : ".$value."<br>";
    if($key=='password'){

        echo "<label><input type='text' name='{$key}2' value='{$value}' required>{$key}2</label> <br/>";
    }
    echo "<label><input type='text' name='{$key}' value='{$value}' required>{$key}</label> <br/>";

}

echo " <input name='edit' type=\"submit\" value=\"edit\"/><br/>";

