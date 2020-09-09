<div class= "login">
    <h1>SHOPPING CART</h1>
</div>

<?php
    include("../../install.php");
    if($_SESSION["shopping_cart"]){
    echo "<br>
        <table class=\"tableStyle\">
            <thread>
            <tr>
                <th>image</th>
                <th>item name</th>
                <th>unit price</th>
                <th>quantity</th>
                <th>items total</th>
            </tr>
            </thread>"; 
    $total_price = 0;
    $i = 0;
    foreach ($_SESSION["shopping_cart"] as $item){
            $id_item = $item['id_item'];
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $items_total = $item['quantity'] * $item['price'];
            $img = $item['img'];
            $total_price += $items_total;
            
            echo "<tbody>
                <tr> 
                    <td> <img src= ".$img." width=\"100px\"></td> 
                    <td>$name</td>
                    <td>$price €</td>
                    <td>$quantity
                        <form action='' method= 'post'>
                            <input type='hidden' name='id_item' value='$id_item'>
                            <input type='submit' name='minus_one' value='-'>
                        </form>
                        <form action='' method= 'post'>
                            <input type='hidden' name='id_item' value='$id_item'>
                            <input type='submit' name='plus_one' value='+'>
                        </form>
                    </td>
                    <td>$items_total €</td>
                    <td>
                        <form action='' method= 'post'>
                            <input type='hidden' name='id_item' value='$id_item'>
                            <input type='submit' name='delete' value='Delete'>
                        </form>
                    </td> 
                </tr>
                </tbody>
                ";
        }
        echo "<tfoot>
            <tr>
                <td colspan=\"4\"></td>
                <td>TOTAL: € $total_price </td>
                <td>
                    <form action='' method= 'post'>
                        <input type='hidden' name='total' value='$total_price'>
                        <input type='submit' name='order' value='Place order' style=\"background-color: gold\">
                    </form>
                </td>
            </tr>
           
            </tfoot>
            </table>";
    }
    else{
        echo "<p style=\"color: red;\"> You basket is empty </p>";
	}
	
    function remove_from_cart($item){
        foreach ($_SESSION['shopping_cart'] as &$sub_array){
            if($sub_array['id_item'] == $item){
                $sub_array = null;
            break;
            }
        }
        $_SESSION['shopping_cart'] = array_filter($_SESSION['shopping_cart']);
        echo "<meta http-equiv='refresh' content='0'>";  
    }

    if (isset($_POST['delete'])) {
        if ($_POST['delete'] == "Delete") {
            $id = $_POST['id_item'];
            remove_from_cart($id);
            }
    }
    
    if (isset($_POST['minus_one'])) {
        if ($_POST['minus_one'] == "-") {
            $id = $_POST['id_item'];
            foreach ($_SESSION["shopping_cart"] as &$item){
                if ($id == $item['id_item']){
                    $item['quantity'] -= 1;
                    if ($item['quantity'] == 0){
                        remove_from_cart($id);
                    }
                break;
                }
            echo "<meta http-equiv='refresh' content='0'>";  
            } 
        }
    }
    if (isset($_POST['plus_one'])) {
        if ($_POST['plus_one'] == "+") {
            $id = $_POST['id_item'];
            foreach ($_SESSION["shopping_cart"] as &$item){
                if ($id == $item['id_item']){
                    if ($item['quantity'] > 5){
                        echo "<p style=\"color: red;\"> You've ordered all availabe items</p>";
                    }
                    else{
                        $item['quantity'] += 1;
                        echo "<meta http-equiv='refresh' content='0'>";  
                    }
                break;
            }
        } 
        }
    }
    if (isset($_POST['order'])) {
        if ($_POST['order'] == "Place order") {
            if ($_SESSION["loggued_on_user"] == ""){
                echo "<p style=\"color: red;\"> please, log in to proceed </p>";
            }
            else{
                $id = $_POST['id_item'];
                $login = $_SESSION['loggued_on_user'];

                $date = date("Y-m-d");

                $sql = "SELECT `id_customer` from users WHERE login = '$login'";
                $query = mysqli_query($db_connect, $sql) OR
                die ('Error connecting `users` table: ') . mysqli_error($db_connect);
                $result = mysqli_fetch_assoc($query);
                $id_customer = $result['id_customer'];
                
                $total_price = $_POST['total'];
                $sql = "INSERT INTO `orders` VALUES (NULL,'$id_customer', '$total_price', '$date')";
                $query = mysqli_query($db_connect, $sql) OR
                die ('Error connecting `orders` table: ') . mysqli_error($db_connect);
                
                $sql = "SELECT LAST_INSERT_ID()";
                $query = mysqli_query($db_connect, $sql) OR
                die ('Error requesting last buyer info: ') . mysqli_error($db_connect);
                $result = mysqli_fetch_assoc($query);
                $id_order = $result['LAST_INSERT_ID()'];


                foreach ($_SESSION["shopping_cart"] as $item){
                    $id_item = $item['id_item'];
                    $price = $item['price'];
                    $quantity = $item['quantity'];

                    $sql = "INSERT INTO `order_details` VALUES (NULL,'$id_order', '$id_item', '$quantity', '$price', '$date')";
                    $query = mysqli_query($db_connect, $sql) OR
                    die ('Error filling `order_details` table: ') . mysqli_error($db_connect);
                }
                echo "<p> Your order has been successfully placed!</p>";
                $_SESSION['shopping_cart'] = "";
            }
        }
    }
?>