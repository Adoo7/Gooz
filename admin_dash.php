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

<!--<button onclick="createArticle()" >Create New Article</button>-->
<div class="container-fluid">
<!-- data tabs -->
<div class="row d-flex justify-content-center">
    <div class ="col-12 col-lg-4 p-1 border border-top-0 rounded-bottom">
        <ul class="mt-2 nav nav-tabs nav-justified" id="navtabs">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Articles</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" id="unpublished-articles-tab" data-bs-toggle="tab" href="#unpublished-article-tab-pane">unpublished articles</a></li>
                    <li><a class="dropdown-item" id="published-article-tab" data-bs-toggle="tab" href="#published-article-tab-pane">published articles</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-bs-toggle="tab" href="#users-tab-pane">Users</a>
            </li>
        </ul>
        
        <div class="tab-content">
            <div class="tab-pane fade show active col-11" id="unpublished-article-tab-pane">
                <h2>All Unpublished Articles</h2>

                <?php
                $unPublishedArticle = new Article();
                $unPublishedArticles = $unPublishedArticle->getAllUnPublishedArticles();

                foreach ($unPublishedArticles as $article) {
                    echo '<article>' .
                            '<h3>' . $article->getHeadLine() . '</h3>' .
                            '<p>' . $article->getArticleText() . '</p>' .
                            '<button onclick="viewArticle('.$article->getArticleID().')">Read more</button>'. //show article page
                            '<button onclick="editArticle('.$article->getArticleID().')">Edit</button>'. //show article edit form
                            '<button onclick="confirmDeleteArticle('.$article->getArticleID().')">Delete</button>' . //show popup to confirm deletion
                         '</article>';
                }
                ?>
            </div>
        
            <div class="tab-pane fade show col-11" id="published-article-tab-pane">
                <h2>All Published Articles</h2>

                <?php
                $publishedArticle = new Article();
                $publishedArticles = $publishedArticle->getAllPublishedArticles();

                foreach ($publishedArticles as $article) {
                    echo '<article>' .
                            '<h3>' . $article->getHeadLine() . '</h3>' .
                            '<p>' . $article->getArticleText() . '</p>' .
                            '<button onclick="viewArticle('.$article->getArticleID().')">Read more</button>'. //show article page
                            '<button onclick="confirmDeleteArticle('.$article->getArticleID().')">Delete</button>'.
                         '</article>';
                }
                ?>
            </div>


            <div class="tab-pane fade show col-11" id="users-tab-pane">
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
            </div>
        </div>
    </div>
    
    <!-- controls -->
    <div class ="col-11 col-md-8">
    </div>
</div>
</div>