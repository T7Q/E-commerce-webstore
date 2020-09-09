<div class= "admin">
    <h1>ADD NEW ITEM</h1>
</div>

<div>
    <form action = "" method="POST"> 
        name: <input type="text" name="item_name" value="" />
        <br/>
        description: <input type="text" name="description" value="" />
        <br/>
        price: <input type="text" name="price" value="" />
        <br/>
        img: <input type="text" name="img" value="" />
        <br/>
        <input type="checkbox" name="category[]" value="cookies" /><label for="category_1"> cookies</label>
        <br/>
        <input type="checkbox" name="category[]" value="cakes" /><label for="category_2"> cakes</label>
        <br/>
        <input type="checkbox" name="category[]" value="subscribtion box" /><label for="category_3"> subscribtion box</label>
        <br/>
        <input name="submit" type="submit" value="ADD"></p>
    </form>

</div>

<?php
?>

<?php
    if(isset($_POST['submit'])){
        if($_POST['submit'] === 'ADD'){
            if(!empty($_POST['item_name']) and !empty($_POST['description']) and !empty($_POST['price'])){
                $name = mysqli_real_escape_string($db_connect, $_POST['item_name']);
                $description = mysqli_real_escape_string($db_connect, $_POST['description']);
                $price = mysqli_real_escape_string($db_connect, $_POST['price']);
                $img = mysqli_real_escape_string($db_connect, $_POST['img']);
				
                if(!empty($_POST['category'])){

                    $cat_1 = 0;
                    $cat_2 = 0;
                    $cat_3 = 0;

                    foreach($_POST['category'] as $selected){
                        if ($selected == 'cookies')
                            $cat_1 = 1;
                        if ($selected == 'cakes')
                            $cat_2 = 1;
                        if ($selected == 'subscribtion box')
                            $cat_3 = 1;
                    }

                    $sql = "INSERT INTO items (`item_name`,`price`,`description`,`img`) VALUES ('$name', '$price', '$description', '$img')";
                    $query = mysqli_query($db_connect, $sql) OR
                    die ('Error adding new item to `items` table: check your input data ') . mysqli_error($db_connect);
					
					
					$sql = "SELECT LAST_INSERT_ID()";
					$query = mysqli_query($db_connect, $sql) OR
					die ('Error requesting last buyer info: ') . mysqli_error($db_connect);
					$result = mysqli_fetch_assoc($query);
					$id = $result['LAST_INSERT_ID()'];

                    if ($cat_1 == 1){
	
						$sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 1)";
                        $query = mysqli_query($db_connect, $sql) OR
                        die ('Error adding new item to `items` table2: ') . mysqli_error($db_connect);
                    }
                    if ($cat_2 == 1){
					
                        $sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 2)";
                        $query = mysqli_query($db_connect, $sql) OR
                        die ('Error adding new item to `items` table3: ') . mysqli_error($db_connect);
                    }
                    if ($cat_3 == 1){
		
                        $sql = "INSERT INTO `itemcategory`(`id_item`,`id_category`) VALUES ($id, 3)";
                        $query = mysqli_query($db_connect, $sql) OR
                        die ('Error adding new item to `items` table4: ') . mysqli_error($db_connect);
                    }
                    echo "<p>Item $name has been successfully added</p>";

                }
                else{
                    echo "<p>Please select at least one category</p>";
                }
            }
            else{
                echo "<p style=\"color:red\">Please fill out all sections</p>";
            }
        }
    }
?>