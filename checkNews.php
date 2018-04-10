<?php
session_start();
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 16:55
 */


require_once("config.php");


function updateNews($connect, $id)
{
    $query1 = "UPDATE news SET `category_id`='" . $_POST['category_id'] . "', `news_header`='" . $_POST['news_header'] . "',`news_body` ='" . $_POST['news_body'] . "',news_pre ='" . $_POST['news_pre'] . "',news_image ='" . $_POST['news_image'] . "',date ='" . $_POST['date'] . "',title ='" . $_POST['title'] . "',meta_description ='" . $_POST['meta_description'] . "' WHERE `news_id`='{$_POST['news_id']}'";
    mysqli_query($connect, $query1);
}


function createNews($connect)
{
    $query2 = "INSERT INTO news SET `category_id`='" . $_POST['category_id'] . "', `news_header`='" . $_POST['news_header'] . "',news_body ='" . $_POST['news_body'] . "',news_pre ='" . $_POST['news_pre'] . "',news_image ='" . $_POST['news_image'] . "',date ='" . $_POST['date'] . "',title ='" . $_POST['title'] . "',meta_description ='" . $_POST['meta_description'] . "'";
    mysqli_query($connect, $query2);
}


if ($_POST['News'] == "edit") {
    if (!empty($_POST['news_id']) && !empty($_POST['category_id']) && !empty($_POST['news_header']) && !empty($_POST['news_body']) && !empty($_POST['news_pre']) && !empty($_POST['news_image']) && !empty($_POST['date']) && !empty($_POST['title']) && !empty($_POST['meta_description'])) {
        updateNews($connect, $_POST['news_id']);
        unset($_SESSION['news_error']);
    }else{
        $_SESSION['news_error']="input information are not correct";
    }
} elseif ($_POST['News'] == "create") {
    if (!empty($_POST['category_id']) && !empty($_POST['news_header']) && !empty($_POST['news_body']) && !empty($_POST['news_pre']) && !empty($_POST['news_image']) && !empty($_POST['date']) && !empty($_POST['title']) && !empty($_POST['meta_description'])) {
        createNews($connect);
        unset($_SESSION['news_error']);
    }else{
        $_SESSION['news_error']="input information are not correct";
    }
}
header('Location: /index.php');
exit();