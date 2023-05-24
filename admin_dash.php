
<head>
    
    <script>
    function confirmDelete(userId) 
    {
        if (confirm("Are you sure you want to delete this user?")) 
        {
            window.location.href = "delete_user.php?id=" + userId;
        }
    }
    function confirmDeleteArticle(articleId)
    {
        if(confirm("Are you sure you want to delete this article?"))
        {
            window.location.href = "delete_article.php?id=" + articleId;
        }
    }
    function editArticle(articleId)
    {
        window.location.href = "article_edit.php?id=" + articleId;
    }
    function viewArticle(articleId)
    {
        window.location.href = "article.php?id=" + articleId;
    }
    function createArticle()
    {
        window.location.href = "article_form.php";
    }
    </script>
</head>

<button onclick="createArticle()" >Create New Article</button>

<section class="latest-news">
    
    <h2>All Unpublished Articles</h2>

    <?php
    $unPublishedArticle = new Article();
    $unPublishedArticles = $unPublishedArticle->getAllUnPublishedArticles();

    foreach ($unPublishedArticles as $article) {
        echo '<article class="news-article">' .
                '<h3>' . $article->getHeadLine() . '</h3>' .
                '<p>' . $article->getArticleText() . '</p>' .
                '<button onclick="viewArticle('.$article->getArticleID().')">Read more</button>'. //show article page
                '<button onclick="editArticle('.$article->getArticleID().')">Edit</button>'. //show article edit form
                '<button onclick="confirmDeleteArticle('.$article->getArticleID().')">Delete</button>' . //show popup to confirm deletion
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
          '<button onclick="viewArticle('.$article->getArticleID().')">Read more</button>'. //show article page
          '<button onclick="confirmDeleteArticle('.$article->getArticleID().')">Delete</button>'.
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