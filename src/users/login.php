<div class= "login">
    <h1>LOGIN</h1>
    <form action = "" method="POST">
        <input type="text" name="login" placeholder="Login" value="" />
        <br/>
        <input type="password" name="passwd" placeholder="Password" value="" />
        <br>
        <input name="submit" type="submit" value="OK"/>
    </form>
    <br/>
    <div><a href="index.php?page=create">create account</div>
</div>

<?php
    if(isset($_POST['submit'])){
        if($_POST['login'] && $_POST['passwd'] && $_POST['submit'] === 'OK'){
            $login = mysqli_real_escape_string($db_connect, $_POST['login']);
            $passwd = mysqli_real_escape_string($db_connect, $_POST['passwd']);
            $hashed_passwd = hash('whirlpool', $passwd);
            $submit = $_POST['submit'];

            $sql = "SELECT * FROM `users` WHERE login = '$login'";
            $query = mysqli_query($db_connect, $sql);
            $row = mysqli_fetch_array($query);
            if($row){
                if($row['password'] == $hashed_passwd){
                    $_SESSION['loggued_on_user'] = $login;
                    if ($row['type'] === "admin"){
						$_SESSION['adusername'] = "admin";
                        header("Location: src/admin/admin_home.php");
                    }
                    else{   
                        header("Location: index.php");
                    }
                }
                else{
                    echo "<p class= \"login\">Wrong password<p>";
                }
            }
            else{
                echo "<p class= \"login\"> Seems like you don't have account yet.</p>";
            }
        }
        else{
            echo "<p style=\"login\">Error: enter your login and password.</p>";
        }
    }
?>