<?php
    
include 'header.php';
include './Database.php';
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form

    $articleTitle;
    $articleText;
    $articleVideo;
    $articleImage;
    $articleCategory;
    
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

<form action="post">
    <table>
        <tr>
            <td>Article title</td>
            <td><input type="text" name="articleTitle"></input></td>
        </tr>
        <tr>
            <td>Article text</td>
            <td><input type="text" name="articleText"></input></td>
        </tr>
        <tr>
            <td>Category</td>
            <td><input type="select" name="articleCategory" value=""></input></td>
        </tr>
        <tr>
            <td>Image</td>
            <td><input type="file" name="articleTitle"></input></td>
        </tr>
        <tr>
            <td>Video</td>
            <td><input type="file" name="articleTitle"></input></td>
        </tr>
        <tr>
            <input type="submit" value="Save as draft..">
            <input type="submit" value="Publish">
        </tr>
    </table>
</form>