<?php
    $status= "";

    $db_connect = @mysqli_connect($hn, $db_user, $db_pw, $db) OR
    die('Could not connect to MySQL: ' . mysqli_connect_error());    

    $id_item = $_POST['id_item'];
        $sql = "SELECT * FROM items WHERE id_item=".$id_item;
        $query = mysqli_query($db_connect, $sql) OR
        die ('Error connecting `items` table from cart: ') . mysqli_error($db_connect);

        $row = mysqli_fetch_assoc($query);

        $item_to_add = array(
            $id_item=>array(
            'name'=>$row['item_name'],
            'id_item'=>$row['id_item'],
            'price'=>$row['price'],
            'quantity'=>1,
            'img'=>$row['img'])
           );

        if(empty($_SESSION["shopping_cart"])){
            $_SESSION["shopping_cart"] = $item_to_add;
            $status = "<h1> Product is added to your cart!</h1";
        }
        else{
            $flag = 0;
            foreach ($_SESSION["shopping_cart"] as &$item){
                if ($id_item == $item['id_item']){
                    $item['quantity'] += 1;
                    $flag = 1;
                }
            } 
            if($flag == 0){
                    $_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $item_to_add);
                    $status = "<h1>Product is added to your cart!</h1>";
            }
    }
?>