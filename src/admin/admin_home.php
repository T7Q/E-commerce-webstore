<?php
    include("../../install.php");
	session_start();

	if ($_SESSION['adusername'])
	{


		if(!isset($_GET['page'])){
			$page = "admin_info.php";
		}
		else if ($_GET['page'] == "users") {
			$page = "admin_users.php";
		}
		else if ($_GET['page'] == "items") {
			$page = "admin_items.php";
		}
		else if ($_GET['page'] == "orders") {
			$page = "admin_orders.php";
		}
		else if ($_GET['page'] == "add") {
			$page = "admin_add_item.php";
		}
		else if ($_GET['page'] == "logout") {
			$_SESSION['adusername'] = "";
			$_SESSION['loggued_on_user'] = "";
			echo "<meta http-equiv='refresh' content='0'>";
			header("Location: ../../index.php");
		}
		header('Content-type: text/html');
		
	}
	else {
		header("Location: ../../index.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link href="../../css/about.css" rel="stylesheet">
        <link href="../../css/navbar.css" rel="stylesheet">
        <link href="../../css/items.css" rel="stylesheet">
        <link href="../../css/login.css" rel="stylesheet">
        <link href="../../css/cart.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar">
            <ul>
                <li><a href="admin_home.php?page=users">Users</a></li>
                <li><a href="admin_home.php?page=items&category=0">Items (all)</a>
                    <ul class="dropdown">
                        <li><a href="admin_home.php?page=items&category=1">COOKIES</a></li>
                        <li><a href="admin_home.php?page=items&category=2">CAKES</a></li>
                        <li><a href="admin_home.php?page=items&category=3">SUBSCRIBTION BOX</a></li>
                    </ul>            
                </li>
                <li><a href="admin_home.php?page=orders">Orders</a></li>
                <li><a href="admin_home.php?page=add">Add items</a></li>
                <li><a href="admin_home.php?page=logout">Log out</a></li>
            </ul>
        </nav>
        </header>
        <div class="contents-under">
            <?php include $page; ?>
        </div>
    </body>
</html>