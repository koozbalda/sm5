<?php
/**
 * Created by PhpStorm.
 * User: w11402
 * Date: 05.04.2018
 * Time: 9:57
 */
define('HOST', 'localhost');//константа
define('USER', 'root');//константа
define('PASSWORD', '');//константа
define('DATABASE', 'phploc');//константа


$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
$infoConnect=new mysqli(HOST,USER,PASSWORD,'information_schema');