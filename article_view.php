<?php
//   TODO: MAKE THIS A LIST OF TOP VIEWED ARTICLES
//     Create variable to store query
//     loop through query while changing details based on it

//include 'Database.php';
include './ArticleClass.php';

$categoryID = urldecode($_GET['id']);

$db = Database::getInstance();
$dbc = $db->connect();

//determining if user is in dashboard or has clicked a category
if (isset($_GET['search'])) {
    // search query is present in URL, retrieve articles matching search query
    $searchQuery = urldecode($_GET['search']);
    $result = $db->querySQL("SELECT * FROM Article WHERE HeadLine LIKE '%$searchQuery%' OR ArticleText LIKE '%$searchQuery%'");
} else {
    // no search query in URL, determine if user is in dashboard or has clicked a category
    $categoryID = urldecode($_GET['id']);
    if(empty($categoryID)) {
        //should be sorted by views OR likes
        $result = $db->querySQL("SELECT * FROM Article");
    } else {
        $result = $db->querySQL("SELECT * FROM Article WHERE CategoryID = $categoryID");
    }
}

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


if (isset($_GET['search'])) {
    // display search results
    echo '<div class= "row row-cols-1 row-cols-sm-2 row-cols-md-3">';
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
        echo '<div class="col">' .
          '<h3>' . $article->getHeadLine() . '</h3>' .
          '<p>' . $article->getArticleText() . '</p>' .
          '<a href="article.php?id='. $article->getArticleID(). '">Read more</a>' .
          '</div>'; 
    }
    echo '</div>';
} else {
    // display articles for category or all articles
    echo '<div class= "row row-cols-1 row-cols-sm-2 row-cols-md-3">';
    foreach ($articles as $article) {
        echo '<div class="col">' .
          '<h3>' . $article->getHeadLine() . '</h3>' .
          '<p>' . $article->getArticleText() . '</p>' .
                '<a href="article.php?id='. $article->getArticleID(). '">Read more</a>' .
          '</div>'; 
    }
    echo '</div>';
}

?>

<section class="latest-news">
  <h2>Latest News</h2>

  <?php
  
  echo '<div class= "row row-cols-1 row-cols-sm-2 row-cols-md-3">';
  foreach ($articles as $article) {
    echo '<article class="col">' .
      '<h3>' . $article->getHeadLine() . '</h3>' .
      '<p>' . $article->getArticleText() . '</p>' .
      '<a href="article.php?id='. $article->getArticleID(). '">Read more</a>' .
      '</article>'; 
  }
  echo '</div>'

  ?>
</section>