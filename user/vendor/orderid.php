<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
   $_SESSION['user_id'] = rand(1000000, 10000000);
}

require_once '../../admin/vendor/connect.php';
?>

<!doctype html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style>
    
    * {
        
        color: #8ab9bf;
    }

    body {
        background: #2f3c3d;
    }
     button {
        background:#415457
     }
    

    
</style>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Order page</title>
</head>
<body>
   <div class="col">
      <div class="container">
         <div class="row">
            <div class="col">
               <h3 style="text-align: center; color: #8ab9bf;" class="mt-5">Your Order</h3>
               <?php
                  $user_id = $_SESSION['user_id'];
                  $basket = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id'"));
                  $sum = 0;
                  foreach ($basket as $baske)
                  {
                     $prod_id = $baske[1];
                     $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));;
                     $sum += $prod_data['price'] * $baske[2];
                  }

                  mysqli_query($connect, "INSERT INTO orderlist (id_order, orderprice) VALUES (NULL,'$sum')");
                  $order_id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `id_order` FROM `orderlist` ORDER BY `id_order` DESC LIMIT 1"));
                  $order_id = $order_id['id_order'];
                  $table_name = "`cw`.`$order_id`";
                  mysqli_query($connect, "CREATE TABLE $table_name (`product_name` VARCHAR(255) NULL , `product_amount` INT(11) NULL ) ENGINE = InnoDB;");
                  
                  
                  foreach ($basket as $baske)
                  {
                     $prod_id = $baske[1];
                     $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));;
                     $name = $prod_data['name'];
                     mysqli_query($connect, "INSERT INTO $table_name (`product_name`, `product_amount`) VALUES ('$name', '$baske[2]')");

                     ?>
                     <div>
                        <?= $prod_data['name'] ?> x <?= $baske[2] ?>
                     </div>
                     <br></br>
                     <?php
                  }
               ?>
               <?php
               $user_id = $_SESSION['user_id'];
               ?>
               <div>
                  <?= $sum ?> $
               </div>
               <h3 style="text-align: center"><?=$order_id?></h3>
               <form action='../user.php' method='POST'>
                  <button style="background: #658e94; color: #2f3c3d; " type="submit" name="wp-submit" class = "mt-2  btn btn-dark" >Main menu</button>
                  <?php mysqli_query($connect, "DELETE FROM `basket` WHERE `user_id` = '$user_id'"); ?>
               </form>
            </div>
         </div>
      </div>
   </div>
</body>
</html>