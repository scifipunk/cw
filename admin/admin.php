<?php

require_once 'vendor/connect.php';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>

<!-- <link rel="stylesheet" href="../css/main.css"> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

</head>

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
    th, td {
        padding: 10px;
    }

    th {
        background: #415457;
        color: #8ab9bf;
    }

    td {
        background: #50686b;
    }
</style>
<body>
    <div class="row">
    <table class="col-5 m-5" >
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
        </tr>

        <?php


            $products = mysqli_query($connect, "SELECT * FROM `menulist` ORDER BY `id` DESC");


            $products = mysqli_fetch_all($products);


            foreach ($products as $product) {
                ?>
                    <tr data-id="<?= $product[0] ?>" id="elem<?= $product[0] ?>">
                        <td><?= $product[0] ?></td>
                        <td><?= $product[1] ?></td>
                        <td><?= $product[2] ?></td>
                        <td><?= $product[3] ?>$</td>
                        <td><img src = "<?= $product[4] ?>" width="100"></td>
                        <td><a style="text-decoration: none; color: #3ec24b"  href="update.php?id=<?= $product[0] ?>" >Update</a></td>
                        
                        <td>
                        <button id="btn-delete" data-id="<?= $product[0] ?>" class="btn btn-danger" href="vendor/delete.php?id=<?= $product[0] ?>" >Delete</button>
                        <input type="hidden" id="input<?= $product[0] ?>" name="id" value="<?php echo $product[0]; ?>">
                        </td>
                       
                    </tr>

                    <script>
                            
                                $(document).ready(function() {

                                        $("button").click(function(){
                                            var postid1 = $(this).data('id');
                                            
                                            var id = $("#input" + postid1).val(); 
                                            
                                            $.ajax ({
                                                type: "GET", 
                                                    url: "vendor/delete.php", 
                                                    dataType: 'html',
                                                    data: {"id": id}, 
                                                    cache: false, 
                                                    success: function(){ 
                                                        
                                                        let elems = document.querySelectorAll('#elem' + id);
                                                        for (let elem of elems) {
                                                            
                                                                elem.remove();

                                                        }

                                            }});
                                    })
                                    })

                        </script>
                <?php
            }
        ?>
    </table>


    
    </form>
    <div class = "col-1"></div>
    <div class="col-5 mt-5">
    <h3>Add new product</h3>
    <form action="vendor/create.php" method="post" enctype="multipart/form-data">
        <p class="mt-2">Title</p>
        <input type="text" id="title" style="background: #415457; color: #8ab9bf;" name="name">
        <p class="mt-2">Description</p>
        <textarea name="description" id="description" cols="30" rows="5"></textarea>
        <p class="mt-2">Price</p>
        <input type="number" id="price" style="background: #415457; color: #8ab9bf;" name="price">
        <p class="mt-2">Image</p>
        <input type="file" id="img" name="img"> 
        
        <br> </br>
        <input  style="background: #1d5259; color: #8ab9bf;" type="submit" type="button"  value="Add new product" class = "mt-2 border btn btn-light"></input>
    </form>

            


    <form action="order_list.php">
    <input  style="background: #658e94; color: #2f3c3d;" type="submit" name="wp-submit" class = "mt-2 border btn btn-dark" type="button" value="Go to order list"  tabindex="150"> 
    </form>
    </div> 
    </div>
</body>
</html>
