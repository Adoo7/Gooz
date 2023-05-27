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
    
    function showUsers(str)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/getUsers.php?q=" + str, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("users-table").innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    function showUserControls(id)
    {
        //create the AJAX request object
        xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/getUserControls.php?id=" + id, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                document.getElementById("controls").innerHTML = xmlhttp.responseText;
            }
        }
    }
    
    function updateUser(id, username, password, email)
    {
        var r = 0;
        
        if(document.getElementById('viewer').checked == true) {   
            r = 1;
        } 
        else if(document.getElementById('author').checked == true) {   
            r = 2;
        } 
        else if(document.getElementById('admin').checked == true) {   
            r = 3;
        }
        
        //window.alert(id + username + password + email + r);
        //create the AJAX request object
        //xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "AJAXPHP/updateUser.php?id=" + id + "&name=" + username + "&pass=" + password +"&email=" + email + "&roleid=" + r, true);
        xmlhttp.send();
   
        //declare a function that is called when something happens to the request
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                window.alert(xmlhttp.responseText);
            }
        }
        
        showUsers('');
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
                <a class="nav-link dropdown-toggle active" data-bs-toggle="dropdown" href="#">Articles</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item active" id="unpublished-articles-tab" data-bs-toggle="tab" href="#unpublished-article-tab-pane">unpublished articles</a></li>
                    <li><a class="dropdown-item" id="published-article-tab" data-bs-toggle="tab" href="#published-article-tab-pane">published articles</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-bs-toggle="tab" onclick="showUsers('')" href="#users-tab-pane">Users</a>
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
                
                <input type="text" name="Search" size="50" value="" onkeyup="showUsers(this.value)"/>
                
                <div id="users-table"></div>
                
            </div>
        </div>
    </div>
    
    <!-- controls -->
    <div class ="col-11 col-md-8" id="controls"></div>
</div>
</div>