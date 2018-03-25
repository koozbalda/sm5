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



define('HOST', 'localhost');//константа
define('USER', 'root');//константа
define('PASSWORD', '');//константа
define('DATABASE', 'phploc');//константа


$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);


function addInRegTable($connect){
    $query21="INSERT INTO reg_users SET login='".$_POST['login']."',password ='".$_POST['password']."',email ='".$_POST['email']."'";
mysqli_query($connect,$query21);
}


function uniqueDate($data, $what)
{
    $connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    $query1 = "SELECT COUNT(*) AS  kol FROM `reg_users` WHERE `" . $what . "`='" . $data . "'";

    $res = mysqli_fetch_assoc(mysqli_query($connect, $query1));

    if ($res['kol'] == 0) {
        return true;
    }
    return false;
}

function forName($name)
{
    $code = 'utf-8';
    $name = trim($name);
    $arr = explode(' ', $name);
    if (count($arr) > 1) {
        $_SESSION['error']['login'] = "Поле Логин введено неверно. Допустимо только одно слово";
        return false;
    }
    if (mb_strlen($name, $code) < 3 || mb_strlen($name, $code) > 15) {
        $_SESSION['error']['login'] = "Поле Логин введено неверно, длинна должна быть больше 3х символов и менее 15";
        return false;
    }
    if (!uniqueDate($name, 'login')) {
        $_SESSION['error']['login'] = "Кто то уже использует этот логин";
        return false;
    }


    return true;
}


/**
 * @param $email
 * @return bool
 */
function forEmail($email)
{
    $email = trim($email);
    $arr = explode(' ', $email);
    if (strlen($email) < 6 || (count($arr) > 1)) {
        $_SESSION['error']['email'] = "Поле Email введено неверно";
        return false;
    }

    if (!uniqueDate($email, 'email')) {
        $_SESSION['error']['email'] = "Кто то уже использует этот email";
        return false;
    }


    $arr = explode('@', $email);

    if (count($arr) <= 1) {
        $_SESSION['error']['email'] = "Поле email должно содержать @";
        return false;

    }elseif(count($arr) !=2 ) {
        $_SESSION['error']['email'] = "Поле email заполнено не верно";
        return false;
    }
    return true;

}

/**
 * @param $tel
 * @return bool
 */
//function forTel($tel)
//{
//    if (mb_strlen($tel) < 5) {
//        $_SESSION['error']['tel'] = "Слишком короткий номер";
//        return false;
//    }
//
//    for ($i = 0; $i < mb_strlen($tel); $i++) {
//        if (!is_numeric($tel[$i])) {
//            $_SESSION['error']['tel'] = "Допускаются только цифры";
//            return false;
//        }
//    }
//    return true;
//}


/**
 * @param $pswd
 * @return bool
 */
function pswd($pswd)
{
    if(empty($_POST['password2'])){
        $_SESSION['error']['password'] = "Поле пароль2 не заданно";
        return false;
    }else{
        $pswd2=$_POST['password2'];
    }
    //8 и более символов
    if (mb_strlen($pswd) < 7) {
        $_SESSION['error']['password'] = "Поле пароль должно содержать не менее 8 символов ";
        return false;
    }
    // равны между собой
    if (strcmp($pswd, $pswd2) != 0) {
        $_SESSION['error']['password'] = "Пароли не совпадают";
        return false;
    }
    // без пробелов
    $arr = explode(' ', $pswd);
    if (count($arr) != 1) {
        $_SESSION['error']['password'] = "Пробелы запрещены";
        return false;
    }
    return true;
}

//Function from send correct data or error message in session
function session_prepared($index,$bool){
    if (!empty($_POST[$index]) && $bool) {
        $_SESSION[$index] = $_POST[$index];
        unset($_SESSION['error'][$index]);
    } else {
        unset($_SESSION[$index]);
    }

}


//part 1 check name
session_prepared('login',forName($_POST['login']));

//part 2 check email
session_prepared('email',forEmail($_POST['email']));

//part 3 check tel
//session_prepared('tel',forTel($_POST['tel']));

//part 4 check pswd
session_prepared('password',pswd($_POST['password']));

unset($_SESSION['password']);
unset( $_SESSION['registered']);
//if no error, we save email and login in session
if (count($_SESSION['error']) == 0) {
//    $_SESSION['registered']['email'][] = $_SESSION['email'];
//    $_SESSION['registered']['login'][] = $_SESSION['login'];
//    uniqueDate($_POST['login'],'login');
    $_SESSION['registered']='your email registered '.$_POST['email'];
    addInRegTable($connect);
}

//var_dump($_SESSION);
header('Location: /registration.php');
exit();
?>

<!--<br>-->
<!--<br>-->
<!--<br>-->
<!--<br>-->
<!--<a href="index.php">back</a>>-->

















