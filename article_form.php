<?php
    
include 'header.php';
//include './Database.php';
include './user.php';
include 'ArticleClass.php';


$db = Database::getInstance();
$dbc = $db->connect();

$result = $db->querySQL('SELECT * FROM Category');

$list = "";
if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        foreach ($result as $row) {
            //echo $row;
            $list .= '<li><a class="dropdown-item text-light" href="index.php?id='.$row['CategoryID'].'">'.$row['CategoryName'].'</a></li>';
        }
    } else {
        echo "No results found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($dbc);
}

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
    $targetDir = "uploads/";

    
    echo 'everything set <br>';
    
    if ($article->create()) {
        echo 'atricle added';
        $file = new Files();
        $file->getNewArticleID();
            // Image file validation
    if (isset($articleImage) && $articleImage['error'] === UPLOAD_ERR_OK) {
        $imageFileType = strtolower(pathinfo($articleImage['name'], PATHINFO_EXTENSION));
        $allowedImageTypes = array('jpg', 'jpeg', 'png', 'gif');
        
        
        if (in_array($imageFileType, $allowedImageTypes)) {
            
            $article->setImage($articleImage);
            
            $fileName = basename($_FILES["articleImage"]["name"]);
            $file->setFileName($fileName);
            $targetFilePath = $targetDir . $fileName;
            $file->setFlocation($targetFilePath);
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $file->setFileType($fileType);
            
             if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
                if($file->addFile()){
                    echo 'video uploaded';
                }else{
                    echo 'video failed';
                }
             }
            
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
            
            
            $fileName = basename($_FILES["articleVideo"]["name"]);
            $file->setFileName($fileName);
            $targetFilePath = $targetDir . $fileName;
            $file->setFlocation($targetFilePath);
            $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
            $file->setFileType($fileType);
            
             if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
                if($file->addFile()){
                    echo 'video uploaded';
                }else{
                    echo 'video failed';
                }
             }
        } else {
            // Invalid video file type
            // Handle the error or display a message to the user
            echo 'invalid video file type';
        }
    }
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