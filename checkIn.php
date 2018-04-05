<?php
session_start();
//session_destroy();
//exit();
/**
 * Created by PhpStorm.
 * User: Kooz
 * Date: 01.02.2018
 * Time: 18:31
 */


/**
 * @param $name
 * check input name on our rules
 * @return bool
 */


//
//define('HOST', 'localhost');//константа
//define('USER', 'root');//константа
//define('PASSWORD', '');//константа
//define('DATABASE', 'phploc');//константа
//
//
//$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
require_once ('config.php');



function logined($connect,$login, $password)
{

    $login=trim($login);
    $password=trim($password);

    $query1 = "SELECT COUNT(*) AS  kol FROM `reg_users` WHERE `login`='" . $login . "' AND `password`='" . $password . "'";
    $query2 = "SELECT `role` FROM `reg_users` WHERE `login`='" . $login . "' AND `password`='" . $password . "'";

    $res = mysqli_fetch_assoc(mysqli_query($connect, $query1));
    $res2 = mysqli_fetch_assoc(mysqli_query($connect, $query2));
    if ($res['kol'] != 0) {
        $_SESSION['success'] = $login;
        $_SESSION['role'] = $res2['role'];
        return true;
    }
    $_SESSION['error'] = "Поле Логин или Пароль введено неверно.";
    return false;
}



//Function from send correct data or error message in session

    if (!empty($_POST['login'])&&!empty($_POST['password']) && logined($connect,$_POST['login'],$_POST['password'])) {

        unset($_SESSION['error']);
    } else {

        unset($_SESSION['role']);
        unset($_SESSION['success']);
    }







//var_dump($_SESSION);
header('Location: /login.php');
exit();
?>

<!--<br>-->
<!--<br>-->
<!--<br>-->
<!--<br>-->
<!--<a href="index.php">back</a>>-->

















