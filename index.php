<?php
    session_start();
    include("install.php");

    if(!isset($_GET['page']) || $_GET['page'] == "about"){
        $page = "src/pages/about.php";
    } 
    else if($_GET['page'] == "items"){
        $page = "src/pages/items.php";
    }
    else if($_GET['page'] == "contact"){
        $page = "src/contact.html";
    }
    else if($_GET['page'] == "login"){
        $page = "src/users/login.php";
    }
    else if($_GET['page'] == "create"){
        $page = "src/users/create.php";
    }
    else if($_GET['page'] == "modify"){
        $page = "src/users/modify.php";
    }
    else if($_GET['page'] == "logout"){
        $page = "src/users/logout.php";
    }
    else if($_GET['page'] == "cart"){
        $page = "src/cart/cart.php";
    }
    else if($_GET['page'] == "admin"){
        $page = "src/admin/admin.php";
    }
    else if($_GET['page'] == "profile"){
        $page = "src/users/modify.php";
	}
	else if($_GET['page'] == "profile2"){
        $page = "src/users/profile.php";
	}
	else if($_GET['page'] == "delete_user"){
        $page = "src/users/delete_user.php";
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Coookies</title>
        <link href="css/about.css" rel="stylesheet">
        <link href="css/navbar.css" rel="stylesheet">
        <link href="css/items.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">
        <link href="css/cart.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar">
                <ul>
                    <li ><a href="index.php?page=about">ABOUT</a></li>
                    <li ><a href="index.php?page=items&category=0">ALL PRODUCTS</a>
                        <ul class="dropdown"> 
                            <li><a href="index.php?page=items&category=1">COOKIES</a></li>
                            <li><a href="index.php?page=items&category=2">CAKES</a></li>
                            <li><a href="index.php?page=items&category=3">SUBSCRIBTION BOX</a></li>
                        </ul>
                    </li>
                        <?php
                            if ($_SESSION['loggued_on_user'] == "") {
                                echo "<li> <a href=\"index.php?page=login\">login</a></li>";
                            }
                            else{
                                echo "<li> <a href=\"index.php?page=profile\">Profile</a></li>";
                                echo "<li> <a href=\"index.php?page=logout\">logOut</a></li>";
                            }
                        ?>
                    <li><a href="index.php?page=cart">BASKET</a></li>
                </ul>
        </nav>
        <div class="contents-under">
            <?php include $page; ?>
        </div>
    </body>
</html>
