<?php
//   TODO: MAKE THIS A LIST OF TOP VIEWED ARTICLES
//     Create variable to store query
//     loop through query while changing details based on it

include 'Database.php';
include './ArticleClass.php';


$db = Database::getInstance();
$dbc = $db->connect();

$result = $db->querySQL('SELECT * FROM Article');

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

?>

<section class="latest-news">
  <h2>Latest News</h2>

  <?php
  
  foreach ($articles as $article) {
    echo '<article class="news-article">' .
      '<h3>' . $article->getHeadLine() . '</h3>' .
      '<p>' . $article->getArticleText() . '</p>' .
      '<a href="article.php?id='. $article->getArticleID(). '">Read more</a>' .
      '</article>';
  }

  ?>
</section>