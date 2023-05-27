<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

include "../Database.php";
include "../ArticleClass.php";

$id = urldecode($_GET['id']);

$thisArticle = new Article();
$article = $thisArticle->read_single($id);

$article->setHeadLine($_GET['headline']);
$article->setArticleText($_GET['text']);
$article->setPublished($_GET['published']);
$article->setCategoryID($_GET['catid']);
$article->setArticleID($id);

$article->edit();

echo '<h1 class="text-center mt-5">Article '.$_GET['headline'].'" has been successfully updated!</h1>';