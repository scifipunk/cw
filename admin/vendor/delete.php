<?php


require_once 'connect.php';


$id = $_GET['id'];


mysqli_query($connect, "DELETE FROM menulist WHERE `menulist`.`id` = '$id'");


header('Location: ../admin.php');