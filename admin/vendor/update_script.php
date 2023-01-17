<?php


require_once 'connect.php';

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$img = 'uploads/' . $_FILES['img']['name'];
        if (!move_uploaded_file($_FILES['img']['tmp_name'], '../' . $img)) {
            header('Location: ../admin.php');
        }




mysqli_query($connect, "UPDATE `menulist` SET `name` = '$name', `description` = '$description', `price` = '$price', `img` = '$img' WHERE `menulist`.`id` = '$id'");



header('Location: ../admin.php');