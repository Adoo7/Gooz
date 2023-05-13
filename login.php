<?php
session_start();
include './Database.php';
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    //Prepare the SQL query to check if the user exists
    $user = new User();
    
        echo $username;
        echo $password;
        
        $user->checkUser($username, $password); 
        //Check if the entered password matches the hashed password in the database
        if($user->login($username, $password)) {
            //Passwords match, so log in the user
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
            header("Location: index.php");
        } else {
            //Passwords don't match, so show an error message
            $login_err = "Invalid password.";
            echo 'error'; 
        }
}
?>

<html>

<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="login-container">
		<h1>Login</h1>
		<form action="" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" required>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" required>
			<input type="submit" value="Login">
		</form>
	</div>
</body>

</html>