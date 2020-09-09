<div class= "login">
    <h1>CREATE NEW ACCOUNT</h1>
    <form action = "" method="POST"> 
        <input type="text" name="login" placeholder="Login" value="" />
        <br/>
        <input type="password" name="passwd" placeholder="Password" value="" />
        <br/>
        <input type="password" name="conf_passwd" placeholder="Confirm password" value="" />
        <br/>
        <input name="submit" type="submit" value="OK"></p>
    </form>
</div>

<?php
    if(isset($_POST['submit'])){
        if($_POST['submit'] === 'OK'){
			$login = mysqli_real_escape_string($db_connect, $_POST['login']);
            $passwd = mysqli_real_escape_string($db_connect, $_POST['passwd']);
            $conf_passwd = $_POST['conf_passwd'];
            $submit = $_POST['submit'];

        if($login && $passwd && $conf_passwd && $submit && $submit == "OK"){
            if($passwd == $conf_passwd){
                $hashed_passwd = hash('whirlpool', $passwd);

                        $query = mysqli_query($db_connect, "SELECT * FROM `users`");
                        $exists = 0;
                        while($row = mysqli_fetch_array($query)){
                            if($row['login'] == $login){
                                echo "<p style=\"color:red;\">Error: login exists, try to remember your password</p>";
                                $exists = 1;
                            }
                        }
                        if ($exists === 0){
                            $sql = "INSERT INTO users (`login`, `password`) VALUES ('$login', '$hashed_passwd')";
							$query = mysqli_query($db_connect, $sql) OR
							die ('Error adding new item to `items` table0: ') . mysqli_error($db_connect);
							$_SESSION['loggued_on_user'] = $login;
							header("Location:index.php");
							//echo "YAY! You account has been created, you proceed shopping!";
                        }
            }
            else{
                echo "<p class= \"login\">Error: passwords do not match</p>";
            }
        }
        else{
            echo "<p class= \"login\">Error: data is missing</p>";
                }
        }
    }
?>
