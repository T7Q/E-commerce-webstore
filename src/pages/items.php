<div class="contents-under"></div>

<?php
                    $hn = 'localhost';
                    $db_user = 'root';
                    $db_pw = 'base20';
                    $db = 'db_shop';

                $db_connect = mysqli_connect($hn, $db_user, $db_pw, $db);

                if (mysqli_connect_errno()) {
                    printf("failed to show items: %s\n", mysqli_connect_error());
                    exit();
                }
                if($_GET['category'] == 0){
                    $sql = "SELECT * FROM items";
                }
                else{
                    $sql = "SELECT * FROM `items` JOIN `itemcategory` ON `items`.`id_item` = `itemcategory`.`id_item` WHERE `itemcategory`.`id_category` =".$_GET['category'];
                }
                
                $result = mysqli_query($db_connect, $sql);
                foreach ($result as $elem){
                    $id = $elem['id_item'];
                    echo"
                    <table class =\"items\">
                        <tr>
                            <td rowspan =\"4\" style=\" width: 30% \"><img src=".$elem['img']."></td>
                            <td style=\"font-size: 2vw width: 70%\">".$elem['item_name']."</td>
                        </tr>
                        <tr>
                            <td style=\"font-size: 1.2vw color: #e1be64 width: 70%\">".$elem['price']."€</td>
                            </tr>
                        <tr>
                            <td style=\"font-size: 0.5vw width: 70% color:black \">".$elem['description']."</td>
                        </tr>
                        <tr>
                            <td style=\" width: 70%\">
                            <form action='' method= 'post'>
                            <input type='hidden' name='id_item' value='$id'>
                            <input type='submit' name='buy' value='Buy'>
                            </form>
                            </td>
                        </tr>
                    </table>
                    <hr/>";    
                }

            mysqli_close($db_connect);
?> 

<?php
    if (isset($_POST['buy'])) {
        
        if ($_POST['buy'] == "Buy") {
            include ("src/cart/add_to_cart.php");
        }
    }
?>