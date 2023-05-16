<?php
include 'header.php';
include './Database.php';
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $roleID = $_POST['role'];
    
    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    //Prepare the SQL query to check if the user exists
    $user = new User();
    
    $user->setUsername($username);
    $user->setPasswpord($password);
    $user->setEmail($email);
    $user->setRoleID($roleID);


    if($user->registerUser()) {
        header("Location: login.php");
    }
    
}
?>

<html>

<head>
	<title>Register Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="login-container">
		<h1>Register</h1>
		<form action="" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" required>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" required>
                        <label>    
                        <input type="radio" name="role" value="1">Viewer</label>
                        <label>
                        <input type="radio" name="role" value="2">Author</label>
                        <label for="email">Email:</label>
			<input type="email" name="email" id="email" required>
			<input type="submit" value="Create account">

		</form>
	</div>
</body>

</html>