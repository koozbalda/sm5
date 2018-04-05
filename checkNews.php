<?php
session_start();
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 16:55
 */


require_once ("config.php");


function updateNews($connect,$id)
{
    $query21 = "UPDATE news SET `news_header`='" . $_POST['news_header'] . "',news_body ='" . $_POST['news_body'] . "',news_pre ='" . $_POST['news_pre'] . "',news_image ='" . $_POST['news_image'] . "',date ='" . $_POST['date'] . "',title ='" . $_POST['title'] . "',meta_description ='" . $_POST['meta_description'] . "' WHERE `news_id`='{$_POST['news_id']}'";
    mysqli_query($connect, $query21);
}


if(!empty($_POST['news_id'])&&!empty($_POST['news_header'])&&!empty($_POST['news_body'])&&!empty($_POST['news_pre'])&&!empty($_POST['news_image'])&&!empty($_POST['date'])&&!empty($_POST['title'])&&!empty($_POST['meta_description'])){
    updateNews($connect,$_POST['news_id']);
}
