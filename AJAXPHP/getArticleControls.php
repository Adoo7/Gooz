<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

$id = $_GET['id'];

include "../Database.php";
include "../ArticleClass.php";

//to get the list of categories from the database
    $db = Database::getInstance();
    $dbc = $db->connect();
    $result = $db->querySQL('SELECT * FROM Category');
    
    $list = "";
    

$thisArticle = new Article();
$article = $thisArticle->read_single($id);

$boolPublished = '';
//disable publish button if article published already
if($article->getPublished() == 1) {
    $boolPublished = 'disabled';
} else {
    $boolPublished = '';
}

if ($result) {
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0) {
            foreach ($result as $row) {
                //echo $row;
                if ($article->getCategoryID() == $row['CategoryID']) {
                    $list .= '<option selected value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
                } else {
                    $list .= '<option value="'.$row['CategoryID'].'">'.$row['CategoryName'].'</option>"></li>';
                }
                
            }
        } else {
            echo "No results found.";
        }
    } else {
        echo "Error executing query: " . mysqli_error($dbc);
    }

if($article->read_single($id)){
    
    $id = $article->getArticleID();
    $title = $article->getHeadLine();
    $text = $article->getArticleText();
    $published = $article->getPublished();
    $articleCreator = $article->getArticleCreator();
    $publishDate = $article->getPublishDate();
    
    echo '   
        <form class="d-flex flex-column gap-3 my-5 mx-2" id="edit_form">
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
            <div class="d-flex row gap-5 mx-0">
                <button id="saveButton" class="col btn btn-secondary btn-block mb-4" type="submit"
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 0, articleCategory.value)">Save changes</button>
                <button class="col btn btn-primary btn-block mb-4" type="submit" '.$boolPublished.'
                onclick="updateArticle('.$id.', articleTitle.value, articleText.value, 1, articleCategory.value)">Publish</button>
            </div>
            <div class="d-flex justify-content-end" id="changes"></div>
        </form>
     ';
    
}