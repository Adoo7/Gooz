<?php
    
include 'header.php';
include './Database.php';
include './user.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Get the username and password from the form

    $articleTitle = $_POST['articleTitle'];
    $articleText = $_POST['articleText'];
    $articleCategory = $_POST['articleCategory'];
    $articleImage = $_POST['articleImage'];
    $articleVideo = $_POST['articleVideo'];
    
    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    $article = new Article();
    
    $article->setHeadLine($articleTitle);
    $article->setArticleText($articleText);
    $article->setArticle; //set article image if file is valid
    $article->setArticleText($articleText); //set article video if file is provided and valid
    
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
            <td><input type="select" name="articleCategory"></input></td>
        </tr>
        <tr>
            <td>Image</td>
            <td><input type="file" name="articleImage"></input></td>
        </tr>
        <tr>
            <td>Video</td>
            <td><input type="file" name="articleVideo"></input></td>
        </tr>
        <tr>
            <input type="submit" value="Save as draft..">
            <input type="submit" value="Publish">
        </tr>
    </table>
</form>