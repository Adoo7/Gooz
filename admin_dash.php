<section class="latest-news">
    
    <h2>All Unpublished Articles</h2>

    <?php
    $unPublishedArticle = new Article();
    $unPublishedArticles = $unPublishedArticle->getAllUnPublishedArticles();

    foreach ($unPublishedArticles as $article) {
        echo '<article class="news-article">' .
                '<h3>' . $article->getHeadLine() . '</h3>' .
                '<p>' . $article->getArticleText() . '</p>' .
                '<a href="article.php">Read more</a>' .
                '<button type="button">Edit</button>' . //show article edit form
                '<button type="button">Delete</button>' . //show popup to confirm deletion
            '</article>';
    }
    ?>
 
</section>

<section class="latest-news">
    
    <h2>All Published Articles</h2>

    <?php
    $publishedArticle = new Article();
    $publishedArticles = $publishedArticle->getAllPublishedArticles();

    foreach ($publishedArticles as $article) {
        echo '<article class="news-article">' .
          '<h3>' . $article->getHeadLine() . '</h3>' .
          '<p>' . $article->getArticleText() . '</p>' .
          '<a href="article.php">Read more</a>' .
          '</article>';
    }
    ?>

</section>

<section class="latest-news">
    
    <h2>Users</h2>

    <table>
            <thead>
              <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role ID</th>
              </tr>
            </thead>
            <tbody>
    
    <?php
//        echo '<tr>
//                <td>1</td>
//                <td>JohnDoe</td>
//                <td>password123</td>
//                <td>johndoe@example.com</td>
//                <td>2 (Author)</td>
//            </tr>'; 
    $user = new User();
    $user->intWithUid($_SESSION['UserID']);
    echo $user->getUsername();
    
    $users = $user->getUserList();
    
    foreach ($users as $user) {
        echo '<tr>
                <td>1</td>
                <td>JohnDoe</td>
                <td>password123</td>
                <td>johndoe@example.com</td>
                <td>2 (Author)</td>
            </tr>';            
    }
    ?>
        </tbody>
    </table>
</section>