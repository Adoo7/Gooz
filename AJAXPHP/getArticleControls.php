<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
session_start();

$id = $_GET['id'];

include "../Database.php";
include "../ArticleClass.php";
include '../user.php';
include '../Files.php';

$db = Database::getInstance();
$dbc = $db->connect();

$user = new User();
$user->initWithUid($_SESSION['UserID']);

$thisArticle = new Article();
if($id > 0) {
    $article = $thisArticle->read_single($id);
} else {
    $article = new Article;
    $article->setPublished(0);
    $article->setHeadLine('headline');
    $article->setArticleText('contents');
    $article->setUserID($_SESSION['UserID']);
    $article->setCategoryID(1);
    $article->create();
    
    $q = 'SELECT LAST_INSERT_ID() as id;';
    $r = $db->querySQL($q);
        
    foreach ($r as $row){
        $id = $row['id'];
    }
    
    $article = $thisArticle->read_single($id);
}


$boolPublished = '';
//disable publish button if article published already
if($article->getPublished() == 1) {
    $boolPublished = 'disabled';
} else {
    $boolPublished = '';
}

//to get the list of categories from the database
$result = $db->querySQL('SELECT * FROM Category');
$list = "";

if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) 
    {
        foreach ($result as $row) 
        {
            //echo $row;
            if ($article->getCategoryID() == $row['CategoryID']) 
            {
                $list .= '<option selected value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
            } 
            else 
            {
                $list .= '<option value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
            }
        }
    } 
    else 
    {
        echo "No results found.";
    }     
} 
else 
{
    echo "Error executing query: " . mysqli_error($dbc);
}


if($id > 0){
    
    $img = '';
    $video = '';
    $imgFile = null;
    $vidFile = null;
    
    $article->read_single($id);
    $file = new Files();
    $file->setArticleID($article->getArticleID());
    $imgFile = $file->getArticleImage();
    $vidFile = $file->getArticleVideo();

    if ($imgFile != null) {
        $img = $imgFile->getFlocation().$imgFile->getFileID().'-'.$imgFile->getFileName();
    }
    
    if ($vidFile != null) {
        $video = $vidFile->getFlocation().$vidFile->getFileID().'-'.$vidFile->getFileName();
    }
    
    
    $id = $article->getArticleID();
    $title = $article->getHeadLine();
    $text = $article->getArticleText();
    $published = $article->getPublished();
    $articleCreator = $article->getArticleCreator();
    $publishDate = $article->getPublishDate();
    
    echo '
        <div class="d-flex flex-column gap-3 my-5 mx-2">
            <div class="d-flex justify-content-around">  <span class="fw-bold">'.$articleCreator.'</span> '.$publishDate.' </div>
            <div class="form-group">
              <input type="text" class="form-control" id="articleTitle" placeholder="Article Title" value="'.$title.'">
            </div>
            <div class="form-group">
              <textarea class="form-control" id="articleText" placeholder="Article Text" rows="15">'.$text.'</textarea>
            </div>
            <div class="form-group">
              <select class="form-control" id="articleCategory">
                '.$list.'
              </select>
            </div>
            <div class="d-flex col-12">
                <div class="col-6" id="imgUpload">
                    <input type="file" class="form-control mb-1" id="articleImage" value="">
                    <button class="col btn btn-secondary btn-block mb-4" onclick="uploadImage('.$id.')">Upload Image</button>
                    <div class="form-group">
                      <img width=100% style="max-width: 100%; max-height=100%;" id="uploadedImage" src="'.$img.'">
                    </div>
                </div>
                <div class="form-group col-6">
                    <input type="file" class="form-control mb-1" id="articleVideo" value="">
                    <button class="col btn btn-secondary btn-block mb-4" onclick="uploadVideo('.$id.')">Upload Video</button>
                    <video width=100% style="max-width: 100%; max-height=100%;" controls>
                        <source id="uploadedVideo" src="'.$video.'" type="video/mp4">
                    </video>
                </div>
            </div>
            <div class="d-flex row gap-5 mx-0">    
                <button id="saveButton" class="col btn btn-secondary btn-block mb-4" type="submit"
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 0, articleCategory.value)">Save draft</button>
                <button class="col btn btn-primary btn-block mb-4" type="submit" '.$boolPublished.'
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 1, articleCategory.value)">Publish</button>
            </div>';
    if($article->getPublished() == 0){
        echo '<div class="col-12 d-flex row gap-5 mx-0">
                <a href="delete_article.php?id='.$id.'"><button class="col btn btn-secondary btn-block mb-4 w-100">Delete Article</button></a>
            </div>';
    }
        echo '<div class="d-flex justify-content-end" id="changes"></div>
        </div>
     ';
    
}