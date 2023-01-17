<?php

    /*
     * Подключаем файл для получения соединения к базе данных (PhpMyAdmin, MySQL)
     */

    require_once 'vendor/connect.php';

    /*
     * Получаем ID продукта из адресной строки - /product.php?id=1
     */

    $product_id = $_GET['id'];

    /*
     * Делаем выборку строки с полученным ID выше
     */

    $product = mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$product_id'");

    /*
     * Преобразовывем полученные данные в нормальный массив
     * Используя функцию mysqli_fetch_assoc массив будет иметь ключи равные названиям столбцов в таблице
     */

    $product = mysqli_fetch_assoc($product);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


<style>
    
    * {
        
        color: #8ab9bf;
    }

    body {
        background: #2f3c3d;
    }
    
    textarea {
        background: #415457;
        color: #8ab9bf; 
        resize: none;
    }
</style>

<body class="m-5">
    <h3>Update Product</h3>
    <form action="vendor/update_script.php" method="post" enctype = "multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <p class="mt-2">Name</p>
        <input type="text" name="name" style="background: #415457; color: #8ab9bf;" value="<?= $product['name'] ?>">
        <p class="mt-2">Description</p>
        <textarea name="description"  cols="30" rows="5"><?= $product['description'] ?></textarea>
        <p class="mt-2">Price</p>
        <input type="number" name="price" style="background: #415457; color: #8ab9bf;" value="<?= $product['price'] ?>"> 
        <p class="mt-2">Image</p>
        <input type="file"  name="img"  value="<?= $product['img'] ?>"> <br> <br><br> <br>
        <button type="submit" style="background: #658e94; color: #2f3c3d;" class = "mt-2 border btn btn-dark">Update</button>
    </form>
</body>
</html>