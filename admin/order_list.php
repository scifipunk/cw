
<?php

require_once 'vendor/connect.php';

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
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
    <table id="table" class="col-5 m-5"  >
        <tr>
            <th>Order number</th>
            <th>Order content</th>
            <th>Price</th>
        </tr>

        <?php


            $products = mysqli_query($connect, "SELECT * FROM `orderlist`");


            $products = mysqli_fetch_all($products);


            foreach ($products as $product) {
                ?>
                    <tr id="elem<?= $product[0] ?>">
                        <td ><?= $product[0] ?></td>
                        <td ><?php
                        
                        $order_content = mysqli_query($connect, "SELECT * FROM `$product[0]`");
                        $order_content = mysqli_fetch_all($order_content);

                        foreach ($order_content as $content) {

                            print "<span >{$content['0']} x {$content['1']}</span> <br></br>";

                        }

                        ?>
                    
                    </td>
                        <td ><?= $product[1] ?>$</td>
                        <td><button data-id="<?= $product[0] ?>" id="btn"  class="btn btn-danger">Delete</button>
                        <input type="hidden" id="input<?= $product[0] ?>" name="id" value="<?php echo $product[0]; ?>"></td>
                    </tr>
                        

                <?php
            }

        ?>
    </table>
    <script>
                            
                            $(document).ready(function() {

                                    $("button").click(function(){
                                        var postid1 = $(this).data('id');
                                        
                                        var id = $("#input" + postid1).val(); 
                                        
                                        $.ajax ({
                                            type: "GET", 
                                                url: "vendor/delete_order.php", 
                                                dataType: 'html',
                                                data: {"id": id}, 
                                                cache: false, 
                                                success: function(){ 
                                                    
                                                    let elems = document.getElementById('elem' + id);
                                                                                                       
                                                    elems.remove();

                                                   

                                        }});
                                    })
                                    setInterval(function(){
                                        $.ajax({
                                            url:"vendor/realTimeTable.php",
                                            method: "GET",
                                            dataType:"text",
                                            
                                            success:function(data)
                                            {
                                                /* $("#table").html(data); */
                                                location.reload();
                                            }
                                                });
                                            }, 20000);
                                        })

                    </script>
    


    <div clas="col-5">      
    <form action="admin.php">
    <input  style="background: #658e94; color: #2f3c3d;" type="submit" name="wp-submit" class = "m-5  border btn btn-dark" type="button" value="Go to menu list"  tabindex="100" />
    </form>
    </div>
</body>
</html>

