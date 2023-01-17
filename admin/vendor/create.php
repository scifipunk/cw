<?php


require_once 'connect.php';



$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];


$img = 'uploads/' . $_FILES['img']['name'];
        if (!move_uploaded_file($_FILES['img']['tmp_name'], '../' . $img)) {
            header('Location: ../admin.php');
        }



mysqli_query($connect,"INSERT INTO `menulist`(`id`, `name`, `description`, `price`, `img`) VALUES (NULL,'$name','$description','$price','$img')");


header('Location: ../admin.php');