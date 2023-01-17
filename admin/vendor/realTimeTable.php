<?php

require_once 'connect.php';

$output = "";

$output .= "<table id='table' class='col-5 m-5'  >
        <tr>
            <th>Order number</th>
            <th>Order content</th>
            <th>Price</th>
        </tr>";

$products = mysqli_query($connect, "SELECT * FROM `orderlist`");

$products = mysqli_fetch_all($products);

print_r($prodeucts);

            foreach ($products as $product) {
                $output .= "<tr id='elem".$product[0]."'>
                        <td >".$product[0]."</td>
                        <td >";
                    
                        
                        $order_content = mysqli_fetch_all(mysqli_query($connect, "SELECT * FROM `$product[0]`"));
                        
                        foreach ($order_content as $content) {

                            $output .= "<span >".$content['0']." x ".$content['1']."</span> <br></br>";

                        }

                        
                    
                        $output .= "</td><td >".$product[1]."$</td>
                        <td><button data-id=".$product[0]." id='btn'  class='btn btn-danger'>Delete</button>
                        <input type='hidden' id='input".$product[0]."' name='id' value=".$product[0]."></td>
                    </tr>";
                        

                
            }

       
            $output .= "</table>";

            echo $output;



?>