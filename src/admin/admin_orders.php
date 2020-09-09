<div class= "admin">
    <h1>CURRENT ORDERS</h1>
</div>

<?php
    include("../../install.php");
    $sql = "SELECT orders.id_order, users.login, orders.total, orders.purchase_date FROM orders INNER JOIN users ON users.id_customer = orders.id_customer";
    $query = mysqli_query($db_connect, $sql) OR
    die ('Error connecting to `orders` database: ') . mysqli_error($db_connect);

    if ($query > 0){
        echo "<br> 
            <table class=\"tableStyle\">
                <thread>
                    <tr>
                        <th>date</th>
                        <th>order #</th>
                        <th>customer id</th>
                        <th>total</th>
                    </tr>
                </thread>";
        while($row = mysqli_fetch_assoc($query)){
            $id_order = $row['id_order'];
            $customer = $row['login'];
            $total = $row['total'];
            $date = $row['purchase_date'];
            
            echo "<tbody>
                    <tr style=\"background: #e7e6ea\"> 
                        <td style=\" width: 10%; boarder: 1px \"> $date </td> 
                        <td style=\" width: 30%; boarder: 1px \"> $id_order </td>
                        <td style=\" width: 20%; boarder: 1px \"> $customer </td>
                        <td style=\" width: 20%; boarder: 1px \">  $total €</td>
                        </td>
                    </tr>";
            
            $sql2 = "SELECT items.img, items.item_name, order_details.quantity,
            order_details.price, order_details.quantity * order_details.price AS items_total FROM items INNER JOIN order_details ON order_details.id_item = items.id_item WHERE order_details.id_order = '$id_order'";
            $query2 = mysqli_query($db_connect, $sql2) OR
            die ('Error creating orders table: ') . mysqli_error($db_connect);
            
            echo "<tr>
                    <td></td>
                    <td colspan=\"3\">
                        <table class=\"tableStyle\">
                            <thread> 
                                <tr> 
                                    <th>image</th>
                                    <th>item</th>
                                    <th>price</th>
                                    <th>quantity</th>
                                    <th>items total</th>
                                </tr>
                            </thread>
                            <tbody>";

            while($result = mysqli_fetch_assoc($query2)){
                $img = $result['img'];
                $name = $result['item_name'];
                $quantity = $result['quantity'];
                $price = $result['price'];
                $items_total = $result['items_total'];
                echo "<tr>
                            <td style=\" width: 20%; boarder: 1px \"> <img src=".$img ." width=\"100px\"></td>
                            <td style=\" width: 20% boarder: 1px\"> $name</td>
                            <td style=\" width: 20% boarder: 1px\"> $price €</td>
                            <td style=\" width: 20% boarder: 1px\">  $quantity</td>
                            <td style=\" width: 20% boarder: 1px\"> $items_total €</td> 
                        </tr>
                ";}
                echo "</table></td>";
        }
        echo "</tbody></table>";  
    }

    if (isset($_POST['make_admin'])) {
        if ($_POST['make_admin'] == "Make admin") {
            $id = $_POST['id_customer'];
            $sql = "SELECT * FROM `users` WHERE id_customer = '$id'";
            $query = mysqli_query($db_connect, $sql) OR
            die ('Error 1 changing user rights from `users` table: ') . mysqli_error($db_connect);

            if ($query) {
                $sql = "UPDATE `users` SET type = 'admin' WHERE id_customer = '$id'";
                $query = mysqli_query($db_connect, $sql) OR
                die ('Error 2 changing user rights from `users` table: ') . mysqli_error($db_connect);
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }

?>