<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

//show all articles with edit & add & delete functionality
include 'Database.php';
include './ArticleClass.php';


$db = Database::getInstance();
$dbc = $db->connect();

$result = $db->querySQL('SELECT * FROM Article WHERE ');

if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
        // Process the results
    } else {
        echo "No results found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($dbc);
}


foreach ($result as $row) {
    
    $article = new Article();
    $article->setArticleID($row['ArticleID']);
    $article->setHeadLine($row['HeadLine']);
    $article->setArticleText($row['ArticleText']);
    $article->setPublishDate($row['PublishDate']);
    $article->setPublished($row['Published']);
    $article->setNoReaders($row['NoReaders']);
    $article->setNoLikes($row['NoLikes']);
    $article->setNoDislike($row['NoDislike']);
    $article->setCategoryID($row['CategoryID']);
    $article->setUserID($row['UserID']);
    
    $articles[] = $article;
        
    //Uncomment to find out what the query is returning
    //var_dump($row);
}
//show all users with edit add delete functionality 