<a href="article_form.php">create</a>
<head>
    
    <script>
    function confirmDelete(userId) 
    {
        if (confirm("Are you sure you want to delete this user?")) 
        {
            window.location.href = "delete_user.php?id=" + userId;
        }
    }
    </script>
</head>
<section class="latest-news">
    
    <h2>All Unpublished Articles</h2>

    <?php
    $unPublishedArticle = new Article();
    $unPublishedArticles = $unPublishedArticle->getAllUnPublishedArticles();

    foreach ($unPublishedArticles as $article) {
        echo '<article class="news-article">' .
                '<h3>' . $article->getHeadLine() . '</h3>' .
                '<p>' . $article->getArticleText() . '</p>' .
                '<a href="article.php?id='.$article->getArticleID().'">Read more</a>' .
                '<a href="article_edit.php?id='.$article->getArticleID().'">Edit</a>' . //show article edit form
                '<a href="article.php?id='.$article->getArticleID().'">Delete</a>' . //show popup to confirm deletion
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
          '<a href="article.php?id='.$article->getArticleID().'">Read more</a>' .
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
        <td><a href=\"edit_user.php?id=$uid\"><button>edit</button></a></td>
        <td><button onclick=\"confirmDelete($uid)\">delete</button></td>
    </tr>";       
    }
    ?>
        </tbody>
    </table>
</section>