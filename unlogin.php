<?php
session_start();
/**
 * Created by PhpStorm.
 * User: KooZ
 * Date: 22.03.2018
 * Time: 20:55
 */

if(!empty($_SESSION['success'])){

}

header('Location: /login.php');
exit();
?>