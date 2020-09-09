<div class= "admin">
    <h1>ITEMS</h1>
</div>

<?php
    include("../../install.php");
    
    if($_GET['category'] == 0){
        $sql = "SELECT * FROM items";
    }
    else{
        $sql = "SELECT * FROM `items` JOIN `itemcategory` ON `items`.`id_item` = `itemcategory`.`id_item` WHERE `itemcategory`.`id_category` =".$_GET['category'];
    }   

    $query = mysqli_query($db_connect, $sql) OR
    die ('Error 1 showing `items` table: ') . mysqli_error($db_connect);
    
    if ($query > 0){
        echo "<br> 
            <table class=\"tableStyle\">
                <thread> 
                    <tr>
                        <th>item id</th>
                        <th>image</th>
                        <th>description</th>
                    </tr>
                </thread>
                <tbody>";
        while ($row = mysqli_fetch_array($query)){
            
            $id = $row['id_item'];
            $name = $row['item_name'];
            $price = $row['price'];
            $description = $row['description'];

			$sql1 = "SELECT * FROM `itemcategory` where `id_item` = $id";
			$query1 = mysqli_query($db_connect, $sql1) OR
    		die ('Error did not find category for this item: ') . mysqli_error($db_connect);

			$flag1 = 0;
			$flag2 = 0;
			$flag3 = 0;
	
			while ($row1 = mysqli_fetch_array($query1)){
				if ($row1['id_category'] == 1){
					$flag1 = 1;
				}
				if ($row1['id_category'] == 2){
					$flag2 = 1;
				}
				if ($row1['id_category'] == 3){
					$flag3 = 1;
				}
			}
			$cookies = ($flag1 == 1) ? ('Remove from Cookies') : ('Add to Cookies');
			$cat_name1 = ($flag1 == 1) ? ('remove_cat1') : ('add_cat1');
			$cakes = ($flag2 == 1) ? ('Remove from Cakes') : ('Add to Cakes');
			$cat_name2 = ($flag2 == 1) ? ('remove_cat2') : ('add_cat2');
			$box = ($flag3 == 1) ? ('Remove from Box') : ('Add to Box');
			$cat_name3 = ($flag3 == 1) ? ('remove_cat3') : ('add_cat3');
			
            echo "<tr>
                    <td>" . $row['id_item'] . "</td>
                    <td> <img src=". $row['img'] ." width=\"100px\"></td>
                    <td>
                        <form action='' method= 'post'>
                            <input type='text' size=50 name='name_new' value=".$row['item_name'].">
                            <input type='text' size=100 name='description_new' value=".$row['description'].">
                            <input type='text' name='price_new' value=".$row['price'].">
                            <input type='hidden' name='id_item' value=".$row['id_item'].">
                            <br/>
                            <input type='submit' name='modify' value='Modify'>
							<input type='submit' name='delete' value='Delete'>
							<input type='submit' name='$cat_name1' value='$cookies'>
							<input type='hidden' name='flag1' value='$flag1'>
							<input type='hidden' name='flag2' value='$flag2'>
							<input type='hidden' name='flag3' value='$flag3'>
							</form>
						<form action='' method= 'post'>
							<input type='submit' name='$cat_name2' value='$cakes'>
                            <input type='hidden' name='id_item' value='$id'>
                            <input type='hidden' name='flag1' value='$flag1'>
                            <input type='hidden' name='flag2' value='$flag2'>
                            <input type='hidden' name='flag3' value='$flag3'>
							</form>
							<form action='' method= 'post'>
							<input type='submit' name='$cat_name3' value='$box'>
                            <input type='hidden' name='id_item' value='$id'>
                            <input type='hidden' name='flag1' value='$flag1'>
                            <input type='hidden' name='flag2' value='$flag2'>
                            <input type='hidden' name='flag3' value='$flag3'>
						</form>
						</td>
						</tr>";
					}
					echo "</tbody></table>";
				}
				
    if (isset($_POST['delete'])) {
        
        if ($_POST['delete'] == "Delete") {
            $id = $_POST['id_item'];
            
            $sql = "SELECT * FROM `items` WHERE id_item = '$id'";
            $query1 = mysqli_query($db_connect, $sql) OR
            die ('Error 1 removing user from `items` table: ') . mysqli_error($db_connect);				
				$sql2 = "SELECT count(*) FROM `items`";
				$query = mysqli_query($db_connect, $sql2) OR
				die ('Error 2 removing item from `items` table: ') . mysqli_error($db_connect);
				$row = mysqli_fetch_array($query);

				if ( $row['count(*)'] == 1) {
				 	echo "<p>Shop without coookies is not a shoopppp.... </p>";
				}
				else {
					if ($query1) {
						$sql = "DELETE FROM `items` WHERE id_item = '$id'";
						$query = mysqli_query($db_connect, $sql) OR
						die ('Error 2 removing item from `items` table: ') . mysqli_error($db_connect);
						echo "<meta http-equiv='refresh' content='0'>";
					}
				}
			}
		}
    if (isset($_POST['modify'])) {
        if ($_POST['modify'] == "Modify") {
            $id_item = mysqli_real_escape_string($db_connect, $_POST['id_item']);

            $sql = "SELECT * FROM items WHERE id_item = '$id_item'";
            $query = mysqli_query($db_connect, $sql) OR
            die ('Error checking item from `items` table: ') . mysqli_error($db_connect);
            $row = mysqli_fetch_assoc($query);

            $name_old = $row['item_name'];
            $description_old = $row['description'];
            $price_old = $row['price'];

			$name_new = mysqli_real_escape_string($db_connect, $_POST['name_new']);
			$description_new = mysqli_real_escape_string($db_connect, $_POST['description_new']);
			$price_new = mysqli_real_escape_string($db_connect, $_POST['price_new']);

            if (($name_old != $name_new) OR $description_old != $description_new OR $price_old != $price_new){
                $sql = "UPDATE `items` SET item_name = '$name_new', description = '$description_new', price = '$price_new' WHERE id_item = '$id_item'";
                $query = mysqli_query($db_connect, $sql) OR
                die ('Error modifying item from `items` table: ') . mysqli_error($db_connect);
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
	}
	
	
	if ((isset($_POST['remove_cat1']) && $_POST['remove_cat1'] == "Remove from Cookies") || (isset($_POST['remove_cat2']) && $_POST['remove_cat2'] == "Remove from Cakes") || (isset($_POST['remove_cat3']) && $_POST['remove_cat3'] == "Remove from Box")) {
	
		$id = $_POST['id_item'];
		$flag1 = $_POST['flag1'];
		$flag2 = $_POST['flag2'];
		$flag3 = $_POST['flag3'];

		if ($_POST['remove_cat1'] == "Remove from Cookies"){
			
			$sql = "SELECT * FROM `itemcategory` WHERE id_item  = $id AND id_category = 1";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table: ') . mysqli_error($db_connect);

			if ($flag2 == 0 && $flag3 == 0){
				echo "<p>Should be at least in one category</p>";
			}
			else {
				$sql = "DELETE FROM `itemcategory` WHERE id_item  = $id AND id_category = 1";
				$query = mysqli_query($db_connect, $sql) OR
				die ('Error 2 removing user from `users` table: D1') . mysqli_error($db_connect);
				echo "<meta http-equiv='refresh' content='0'>";
			}
			
		}
		else if ($_POST['remove_cat2'] == "Remove from Cakes"){
			$sql = "SELECT * FROM `itemcategory` WHERE id_item  = $id AND id_category = 2";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table: ') . mysqli_error($db_connect);

			if ($flag1 == 0 && $flag3 == 0){
				echo "<p>Should be at least in one category</p>";
			}
			else {
				$sql = "DELETE FROM `itemcategory` WHERE id_item  = $id AND id_category = 2";
				$query = mysqli_query($db_connect, $sql) OR
				die ('Error 2 removing user from `users` table: D2') . mysqli_error($db_connect);
				echo "<meta http-equiv='refresh' content='0'>";
			}
		}
		else if ($_POST['remove_cat3'] == "Remove from Box"){
			$sql = "SELECT * FROM `itemcategory` WHERE id_item  = $id AND id_category = 3";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table: ') . mysqli_error($db_connect);
			if ($flag1 == 0 && $flag2 == 0){
				echo "<p>Should be at least in one category</p>";
			}
			else {
				$sql = "DELETE FROM `itemcategory` WHERE id_item  = $id AND id_category = 3";
				$query = mysqli_query($db_connect, $sql) OR
				die ('Error 2 removing user from `users` table: D3') . mysqli_error($db_connect);
				echo "<meta http-equiv='refresh' content='0'>";
			}
		}
	}

	
	if ((isset($_POST['add_cat1']) && $_POST['add_cat1'] == "Add to Cookies") || (isset($_POST['add_cat2']) && $_POST['add_cat2'] == "Add to Cakes") || (isset($_POST['add_cat3']) && $_POST['add_cat3'] == "Add to Box")) {
		$id = $_POST['id_item'];
		
		if ($_POST['add_cat1'] == "Add to Cookies"){
			$sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 1)";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table A1: ') . mysqli_error($db_connect);
			echo "<meta http-equiv='refresh' content='0'>";
		}
		else if ($_POST['add_cat2'] == "Add to Cakes"){
			$sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 2)";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table: A2') . mysqli_error($db_connect);
			echo "<meta http-equiv='refresh' content='0'>";
		}
		else if ($_POST['add_cat3'] == "Add to Box"){
			$sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 3)";
			$query = mysqli_query($db_connect, $sql) OR
			die ('Error 1 changing user rights from `users` table: A3') . mysqli_error($db_connect);
			echo "<meta http-equiv='refresh' content='0'>";
		}
	}
?>
