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



if(!empty($_SESSION['success'])){
    header('Location: /index.php');
    exit();
}

?>
<head>
    <link rel="stylesheet" href="bootstrap.css">
</head>
<style>
    #my_td {
        text-align: right;
        padding-right: 2%;
    }
    .my_div{
        padding-left: 5%;
        margin-left: 10%;
    }



</style>
<h1 align="center">REGISTRATION</h1>
<br>


<div class="my_div">
    <form class="form-horizontal" action="checkIn.php" method="post">

        <div class="control-group">

            <label class="control-label" for="login">LOGIN</label>

            <div class="controls">

                <input class="" id="login" type="text" name="login" placeholder="login" required
                       value="<?= !empty($_SESSION['login']) ? $_SESSION['login'] : ''; ?>"/>
            </div>
            <div class="controls">
            <span class="help-inline">
            <?php
            if (!empty($_SESSION['error'])) {
                echo '<span style="color:red;">' . $_SESSION['error'] . '</span>';
            }
            ?>
                </span>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label" for="password"> PASSWORD</label>
            <div class="controls">

                <input class="" id="password" type="password" name="password" placeholder="password"
                       required
                       value="<?= !empty($_SESSION['password']) ? $_SESSION['password'] : ''; ?>"/>
            </div>
<!--            --><?php
//            if (!empty($_SESSION['error']['password'])) {
//                echo '<span style="color:red;">' . $_SESSION['error']['password'] . '</span>';
//            }
//            ?>
        </div>

        <input id="my_s" class="btn  btn-success " type="submit" value="SEND"/><br/>

    </form>
    <br>
    <a href="registration.php">Зарегистрироваться</a>
</div>
