<section class="latest-news">
    
    <h2>Unpublished Articles</h2>

    <?php
    $article = new Article();
    $articles = $article->getUnPublishedArticles();

    foreach ($articles as $article) {
        echo '<article class="news-article">' .
          '<h3>' . $article->getHeadLine() . '</h3>' .
          '<p>' . $article->getArticleText() . '</p>' .
          '<a href="article.php">Read more</a>' .
          '</article>';
    }
    ?>

</section>

<section class="latest-news">
    
    <h2>Published Articles</h2>

    <?php
    $article = new Article();
    $articles = $article->getPublishedArticles();

    foreach ($articles as $article) {
        echo '<article class="news-article">' .
          '<h3>' . $article->getHeadLine() . '</h3>' .
          '<p>' . $article->getArticleText() . '</p>' .
          '<a href="article.php">Read more</a>' .
          '</article>';
    }
    ?>

</section>