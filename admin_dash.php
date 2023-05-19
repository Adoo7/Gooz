<a href="article_form.php">create</a>

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
                <th>Role</th>
                
              </tr>
            </thead>
            <tbody>
    
    <?php
    
    $user = new User();
    $users = $user->getAllUsers();
    
    foreach ($users as $user) {
        
        $uid = $user->getUid();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $email = $user->getEmail();
        $roleid = $user->getRoleID();
        
        switch ($roleid) {
            case 3:
                
                $roleid = 'Admin';
                
                break;
            case 2:
                $roleid = 'Author';
                break;
            // More cases can be added here
            case 1:
                $roleid = 'Viewer';
                break;
            default:
                $roleid = 'undefined';
                break;
        }

        
        echo "<tr>
                <td>$uid</td>
                <td>$username</td>
                <td>$password</td>
                <td>$email</td>
                <td>$roleid</td>
                <td><a href="."edit_user.php?id=$uid"."><button>edit</button></a></td>
                <td><a href="."delete_user.php?id=$uid"."><button>delete</button></a></td>
            </tr>";            
    }
    ?>
        </tbody>
    </table>
</section>