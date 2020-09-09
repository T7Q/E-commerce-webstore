<div class= "login">
    <h1>WELCOME TO YOUR PROFILE PAGE</h1>
    <p>To change your password fillout the form:</p>
</div>
<div class= "login">
    <form action = "" method="POST"> 
        <input type="text" name="login" placeholder="Login" value="" />
        <br/>
        <input type="password" name="old_passwd" placeholder="Old password" value="" />
        <br/>
        <input type="password" name="new_passwd" placeholder="New password" value="" />
        <br/>
        <input name="submit" type="submit" value="OK"></p>
		<div><a href="index.php?page=delete_user">delete account</div>
		<div><a href="index.php?page=profile2">edit profile</div>
    </form>
</div>

<?php
    if(isset($_POST['submit']) && $_POST['submit'] == "OK"){
		$login = mysqli_real_escape_string($db_connect, $_POST['login']);
        $old_passwd = mysqli_real_escape_string($db_connect, $_POST['old_passwd']);
		$hashed_passwd_old = hash('whirlpool', $old_passwd);
		$new_passwd = mysqli_real_escape_string($db_connect, $_POST['new_passwd']);
		$hashed_passwd_new = hash('whirlpool', $new_passwd);

        $db_connect = mysqli_connect($hn, $db_user, $db_pw, $db);
        if (mysqli_connect_errno()) {
            printf("failed to connect db_shop from login: %s\n", mysqli_connect_error());
            exit();
        }

        $sql = "SELECT * FROM `users` WHERE login = '$login'";
        $query = mysqli_query($db_connect, $sql);
        $row = mysqli_fetch_array($query);
        
        if($row){
            if($row['password'] == $hashed_passwd_old){
                $sql = "UPDATE users SET password = '$hashed_passwd_new' WHERE login = '$login'";
                $query = mysqli_query($db_connect, $sql);
                echo "<p class=\"login\">You password has been successfully changed.</p>";
            }
            else{
                echo "<p>Error: Current Password is not correct.</p>";
            }
        }
        else{
            echo "<p>Error: Account does not exist.</p>";
        }
    }
?>