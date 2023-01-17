<?php




require_once '../../admin/vendor/connect.php';



if(isset($_POST['pl']))
{
    $id_dish = $_POST['pl'];
    $user_id = $_POST['user_id'];
    $sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM  `basket` WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'"));
    if($sql){
        mysqli_query($connect, "UPDATE `basket` SET `count` = `count` + 1 WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'");
        
    }
    else {
        mysqli_query($connect, "INSERT INTO `basket` (`user_id`, `dish_id`, `count`) VALUES ('$user_id', '$id_dish', '1')");
    }
}

if(isset($_POST['mn']))
{
    $id_dish = $_POST['mn'];
    $user_id = $_POST['user_id'];
    $sql = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM  `basket` WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'"));
    if($sql){
        mysqli_query($connect, "UPDATE `basket` SET `count` = `count` - 1 WHERE `user_id` = '$user_id' AND `dish_id` = '$id_dish'");
    }
    
}

mysqli_query($connect, 'DELETE FROM `basket` WHERE `basket`.`count` = 0');


?>