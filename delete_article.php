<?php
include 'header.php';
include 'ArticleClass.php';

$uid = urldecode($_GET['id']);
$article = new Article();
$thisArticle = $article->read_single($uid);
$thisArticle->delete();

header("Location: dashboard.php");

?>