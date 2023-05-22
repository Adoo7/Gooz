<?php
    
include 'header.php';
//include './Database.php';
include './user.php';
include 'ArticleClass.php';
// check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    echo 'pressed submit <br>';
    
    //Connect to the database
    $db = Database::getInstance();
    $dbc = $db->connect(); 
    
    $article = new Article();
    
    $article->setHeadLine($_POST['articleTitle']);
    $article->setArticleText($_POST['articleText']);
    $article->setPublishDate(date("Y-m-d"));
    
    if ($_POST['submit'] == 'Save as draft..') {
        // Save the article as a draft
        // Additional actions or logic can be placed here
        echo 'set as unpublished <br>';
        $article->setPublished(0);
    } elseif ($_POST['submit'] == 'Publish') {
        // Publish the article
        // Additional actions or logic can be placed here
        echo 'set as published <br>';
        $article->setPublished(1);
    }
    
    $article->setNoReaders(0);
    $article->setNoLikes(0);
    $article->setNoDislike(0);
    
    $article->setCategoryID($_POST['articleCategory']);
    
    $article->setUserID($_SESSION['UserID']);
    
    $articleImage = $_FILES['articleImage'];
    $articleVideo = $_FILES['articleVideo'];
    
    // Image file validation
    if (isset($articleImage) && $articleImage['error'] === UPLOAD_ERR_OK) {
        $imageFileType = strtolower(pathinfo($articleImage['name'], PATHINFO_EXTENSION));
        $allowedImageTypes = array('jpg', 'jpeg', 'png', 'gif');
        
        if (in_array($imageFileType, $allowedImageTypes)) {
            $article->setImage($articleImage);
        } else {
            // Invalid image file type
            // Handle the error or display a message to the user
            echo 'invalid image file type';
        }
    }
    
    // Video file validation
    if (isset($articleVideo) && $articleVideo['error'] === UPLOAD_ERR_OK) {
        $videoFileType = strtolower(pathinfo($articleVideo['name'], PATHINFO_EXTENSION));
        $allowedVideoTypes = array('mp4', 'avi', 'mov', 'wmv');
        
        if (in_array($videoFileType, $allowedVideoTypes)) {
            $article->setVideo($articleVideo);
        } else {
            // Invalid video file type
            // Handle the error or display a message to the user
            echo 'invalid video file type';
        }
    }
    
    echo 'everything set <br>';
    
    if ($article->create()) {
        echo 'added';
        header("Location: dashboard.php");
    } else {
        echo 'something went wrong';
    }
    
    echo 'if statement ran';
    
}


?>

<form action="" method="post">
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
            <td><input type="number" name="articleCategory"></input></td>
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
            <input type="submit" name="submit" value="Save as draft..">
            <input type="submit" name="submit" value="Publish">
        </tr>
    </table>
</form>