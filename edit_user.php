<?php
include 'header.php';
include './Database.php';
include './user.php';

$uid = urldecode($_GET['id']);

$user = new User();
$user->intWithUid($uid);

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
	<title>Edit Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class="login-container">
		<h1>Edit</h1>
		<form action="" method="post">
			<label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="<?php echo $user->getUsername(); ?>" required>
			<label for="password">Password:</label>
                        <input type="password" name="password" id="password" value="<?php echo $user->getPassword(); ?>" required>
                        <label>    
                        <input type="radio" name="role" value="1">Viewer</label>
                        <label>
                        <input type="radio" name="role" value="2">Author</label>
                        <label>    
                        <input type="radio" name="role" value="3">Admin</label>
                        <label for="email">Email:</label>
			<input type="email" name="email" id="email" value="<?php echo $user->getEmail(); ?>" required>
			<input type="submit" value="Edit account">

		</form>
	</div>
</body>

</html>