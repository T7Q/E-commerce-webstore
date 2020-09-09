<div class= "login">
    <h1>USER PROFILE</h1>
    <p>Fill out you profile:</p>
</div>
<div class= "login">
    <form action = "" method="POST"> 
		<input type='hidden' name='id_customer' value='$id'>
        <input type="text" name="first_name" placeholder="First name" value="" />
        <br/>
        <input type="text" name="last_name" placeholder="Last name" value="" />
        <br/>
		<input type="text" name="email" placeholder="Email" value="" />
        <br/>
		<input type="text" name="phone" placeholder="Phone" value="" />
        <br/>
		<input type="text" name="address" placeholder="Address" value="" />
        <br/>
        <input name="submit" type="submit" value="OK"></p>
		<div><a href="index.php?page=profile">change your password</div>
		<div><a href="index.php?page=delete_user">delete account</div>
    </form>
</div>

<?php
    if(isset($_POST['submit']) && $_POST['submit'] == "OK"){
		$login = $_SESSION['loggued_on_user'];
        $first_name = mysqli_real_escape_string($db_connect, $_POST['first_name']);
		$last_name = mysqli_real_escape_string($db_connect, $_POST['last_name']);
		$email = mysqli_real_escape_string($db_connect, $_POST['email']);
        $phone = mysqli_real_escape_string($db_connect, $_POST['phone']);
		$address = mysqli_real_escape_string($db_connect, $_POST['address']);

        $db_connect = mysqli_connect($hn, $db_user, $db_pw, $db);
        if (mysqli_connect_errno()) {
            printf("failed to connect db_shop from login: %s\n", mysqli_connect_error());
            exit();
		}
		
		if($first_name != "" || $last_name != "" || $email != "" || $phone != "" || $address != ""){
			$sql = "UPDATE `users` SET first_name = '$first_name' WHERE login = '$login'";
			$query = mysqli_query($db_connect, $sql);
			$sql = "UPDATE `users` SET last_name = '$last_name' WHERE login = '$login'";
			$query = mysqli_query($db_connect, $sql);
			$sql = "UPDATE `users` SET email = '$email' WHERE login = '$login'";
			$query = mysqli_query($db_connect, $sql);
			$sql = "UPDATE `users` SET phone = '$phone' WHERE login = '$login'";
			$query = mysqli_query($db_connect, $sql);
			$sql = "UPDATE `users` SET address = '$address' WHERE login = '$login'";
			$query = mysqli_query($db_connect, $sql);
			echo "<p class=\"login\">Your profile was successfully updated!</p>";
		}
        else{
            echo "<p>Error: Please check the input</p>";
        }
    }

?>