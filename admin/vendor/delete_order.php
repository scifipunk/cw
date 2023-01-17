<?php



require_once 'connect.php';


$id = $_GET['id'];




 
mysqli_query($connect, "DROP TABLE `cw`.`$id`");

mysqli_query($connect, "DELETE FROM orderlist WHERE `orderlist`.`id_order` = '$id'");



header('Location: ../order_list.php');