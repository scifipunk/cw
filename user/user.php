<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
   $_SESSION['user_id'] = rand(1000000, 10000000);
}

require_once '../admin/vendor/connect.php';
?>

<!doctype html>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<link rel="stylesheet" href="../admin/maps/style.css">
<script src="https://api-maps.yandex.ru/2.1/?apikey=a2d546a2-e46b-443c-a1ff-f9a793166c5b&lang=ru_RU"></script>

<style>
    
    * {
        
        color: #8ab9bf;
    }

    body {
        background: #2f3c3d;
    }
     /* button {
        background:#415457
     }
     */

    
</style>

<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Order page</title>
   </head>
   <body>
      <h1 style="text-align: center; color: #8ab9bf;">Menu</h1>
      <div class="container py-4">
         <div class="row">
            <div class="col">
            <?php
               $products = mysqli_query($connect, "SELECT * FROM `menulist`");
               $products = mysqli_fetch_all($products);
               foreach ($products as $product) {
                  ?>
                     <div class="container">
                        <div class="row">
                           <div class="col">
                              <p><img src="../admin/<?= $product[4] ?>" width="100"></p>
                           </div>
                           <div class="col">
                              <?= $product[2] ?>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col">
                              <?= $product[1] ?>
                           </div>
                           <div class="col">
                              <span id="pricespan<?= $product[0]?>"><?= $product[3] ?></span> $
                           </div>
                           <div class="col">
                              
                              <div id="btns<?= $product[0] ?>" class="btn-group">
                                 <?php
                                    $user_id = $_SESSION['user_id'];
                                    $prod_id = $product[0];
                                    $sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id' AND `dish_id` = '$prod_id'"));
                                    $dish_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name`, `price` FROM `menulist` WHERE `id` = '$prod_id'"));
                                    
                                    $dish_count = 0;
                                   
                                    
                                    $sqlrows = mysqli_num_rows(mysqli_query($connect, "SELECT `count` FROM `basket` WHERE `user_id` = '$user_id' AND `dish_id` = '$prod_id'"));
                                    if ($sqlrows>0){
                                       $dish_count = $sql['count'];
                                    }
                                    
                                    
                                    

                                       ?>
                                       <button id="pl<?= $prod_id ?>" name="pl" class = "btn btn-dark border green"  style="background:#415457" >+</button>
                                       <button id="mn<?= $prod_id ?>" name="mn" class="btn btn-danger"  style="background:#415457" >-</button>
                                       
                                       
                                       <?php
                                       
                                       
                                 
                                 ?> 
                              </div>
                              <br></br>

                                    <script>
                                             
                                             let count<?= $prod_id?> =  <?=$dish_count ?>;

                                             document.getElementById("pl<?php echo $prod_id ?>").addEventListener('click', function() {
                                                
                                                
                                                let newdata = new FormData();
                                                let pl = <?php echo $prod_id ?>,
                                                    user_id = <?php echo $user_id ?>,
                                                    dish_name = '<?= $dish_name['name']; ?>',
                                                    dish_count = count<?= $prod_id?>;

                                                newdata.append('pl', pl);
                                                newdata.append('user_id', user_id);

                                                fetch("http://localhost/user/vendor/add_order.php", {method: 'POST', body: newdata})
                                                .then(function() {
                                                   let element = document.getElementById("orderpos"+pl);
                                                   let elspan = document.getElementById("orderamount"+pl);
                                                   
                                                            
                                                         if (element){
                                                            elspan.innerHTML++;
                                                            
                                                         }
                                                         else {
                                                            let base = document.getElementById("sum");
                                                            let newDiv = document.createElement("div");
                                                            newDiv.id = "orderpos"+pl; 
                                                            newDiv.innerHTML = dish_name + ' x ';
                                                            
                                                            newSpan = document.createElement("span");
                                                            newSpan.id = "orderamount"+pl; 
                                                            newSpan.innerHTML = 1;
                                                            newDiv.insertAdjacentElement('beforeend',newSpan);
                                                            let br = document.createElement('br');  
                                                            newDiv.append(br);
                                                            base.prepend(br);                                         
                                                            base.prepend(newDiv);
                                                            
                                                         }

                                                })
                           

                                             })

                                             document.getElementById("mn<?php echo $prod_id ?>").addEventListener('click', function() {
                                                
                                                
                                                let newdata = new FormData();
                                                let mn = <?php echo $prod_id ?>,
                                                   user_id = <?php echo $user_id ?>,
                                                   dish_name = '<?= $dish_name['name']; ?>',
                                                   dish_count = <?= $dish_count; ?>;
                                                

         
                                                newdata.append('mn', mn);
                                                newdata.append('user_id', user_id);

                                                fetch("http://localhost/user/vendor/add_order.php", {method: 'POST', body: newdata})
                                                .then(function() {
                                                   let element = document.getElementById("orderpos"+mn);
                                                   let elspan = document.getElementById("orderamount"+mn);
                                                   
                                                            
                                                         if (element){
                                                            dish_count--;
                                                            elspan.innerHTML--;
                                                            
                                                            if (elspan.innerHTML == 0){
                                                               element.remove();
                                                            }
                                                         }
                                                         
                                                         

                                                })
                                                count<?= $prod_id?> = dish_count;
                                             })

                                    
                           document.getElementById("pl<?php echo $prod_id ?>").addEventListener('click', function() {
                                 
                                 
                                 let pl = <?php echo $prod_id ?>;
                                 let sumelem = document.getElementById('sumspan');
                                 let element = document.getElementById("orderpos"+pl);    
                                 
                        
                                 let prodprice = document.getElementById("pricespan"+pl);
                                 if(sumelem ){
                                    
                                    sumelem.innerHTML = parseInt(sumelem.innerHTML) + parseInt(prodprice.innerHTML);
                                 }
                                 
                           })
                           document.getElementById("mn<?php echo $prod_id ?>").addEventListener('click', function()  {
                                 let mn = <?php echo $prod_id ?>;
                                 let sumelem = document.getElementById('sumspan');
                                 let element = document.getElementById("orderpos"+mn);    
                                 let prodprice = document.getElementById("pricespan"+mn);

                                 if(element){
                                    sumelem.innerHTML = parseInt(sumelem.innerHTML) - parseInt(prodprice.innerHTML);
                                 }
                                 
                                 

                           })
                              </script>
                              
                                  
                           </div>
                        </div>
                     </div>
                  <?php
               }
               ?>
                  
            </div>
            <div class="col">
               <div class="container">
                  <div class="row">
                     <div class="col">
                        <h3 style="text-align: center; color: #8ab9bf;">Your Order</h3>
                        <?php
                           $basket = mysqli_query($connect, "SELECT * FROM `basket` WHERE `user_id` = '$user_id'");
                           $basket = mysqli_fetch_all($basket);
                           
                           $sum = 0;
                           foreach ($basket as $baske)
                           {
                              $prod_id = $baske[1];
                              $prod_data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `menulist` WHERE `id` = '$prod_id'"));
                              $sum += $prod_data['price'] * $baske[2];

                              ?>
                              <div id="orderpos<?=$prod_id?>">
                                 <?= $prod_data['name'] ?> x  <span id="orderamount<?=$prod_id?>"><?= $baske[2] ?></span> 
                              </div>
                              <br>
                              
                              <?php
                           }
                        ?>
                        <?php
                        $user_id = $_SESSION['user_id'];
                  
                        ?>
                        
                        <div id="sum">
                           
                          
                  
                           
                                 <span  id="sumspan"> <?= $sum ?>  </span>
                        
                           
                          
                                 <span>   $ </span>
                           
                        </div>
                        
                        
                        
                        <form action='vendor\orderid.php' method='POST'>
                           <input type="hidden" name="num" value="<?= $basket ?>">
                           <input type="hidden" name="name" value="<?= $prod_data ?>">
                           <input type="hidden" name="id" value="<?= $user_id ?>">
                           <input style="background: #658e94; color: #2f3c3d;" type="submit" name="wp-submit" class = "mt-2  btn btn-dark" value="Оформить заказ" width='50'>
                        </form>
                     </div>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="container py-4">
                     <h3 class=".center-block">Our restoran</h3>
                     <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aecfb3a9bac5ce2ec02459921d727d49c798007c2d4d45f7dba1d01e0c61179a1&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>      </div>
   </body>
</html>

