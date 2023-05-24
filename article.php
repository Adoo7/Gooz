<?php
    
    include 'header.php';
    //include './Database.php';
    include './user.php';
    include 'ArticleClass.php';
    include 'comment.php';
    $article = new Article();
    $id = urldecode($_GET['id']);
    
    $thisArticle = $article->read_single($id); 
    $text = $thisArticle->getArticleText();
    $title = $thisArticle->getHeadLine();
    
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $comment = new Comment();
        $comment->setArticleID($id);
        $comment->setCommentDate(date("Y-m-d"));
        $comment->setCommentText($_POST['review']);
        $comment->setUserID($_SESSION['UserID']);
        $comment->insertComment();
        
    }
    if($_SESSION['UserID'] == null)
    {
        $hide = 'style="display:none;"';
        
    }
?>
<html>
    
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  
<!--  <script>
    function likeDislikeCounter(button) {
  let likes = parseInt(button.nextElementSibling.innerHTML);
  likes++;
  button.nextElementSibling.innerHTML = likes;
  button.disabled = true; // disable the button after it has been clicked
  // send AJAX request to update the database
  // ...
  document.getElementById("articleLike").innerHTML = likes;
}
  </script>-->
  <script>
      console.log("testefiuheiuo");
  function likeDislikeCounter(button) {
    let isLike = button.classList.contains("like-button") ? 1 : 0;
    let likes = parseInt(button.nextElementSibling.innerHTML) + 1;
    button.nextElementSibling.innerHTML = likes;
    button.disabled = true;

    $.ajax({
      type: "POST",
      url: "updateLikes.php",
      data: {
        article_id: <?php echo $id;?>, // replace with the actual ID of the article
        is_like: isLike,
        count: likes
      },
      success: function(response) {
        console.log("Likes updated successfully. 2.0");
      },
      error: function(xhr, status, error) {
        console.error("Failed to update likes: " + error);
      }
    });
  }
</script>
      
</head>

<body>
  <main>
    <header class="article-header">
      <h2><?php echo $title; ?></h2>
      <p class="meta"><?php echo $thisArticle->PublishDate;?> by <?php echo $thisArticle->getArticleCreator();?></p>
    </header>
    <div class="wrapper">
      <article>

        <div class="content">
            <p><?php echo $text; ?></p>
            <img src="https://via.placeholder.com/500x300" alt="Article Image"><br>
<!--          <video src="https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_640_3MG.mp4"
                 controls></video><! if there is a video run this line, otherwise keep hidden -->
        </div>
      </article>


      <!-- LIKE/DISLIKE FOR ARTICLE -->
      <div <?php echo $hide;?>>
        <button class="like-button" onclick="likeDislikeCounter(this)">Like</button>
        <span id="article-likes"><?php echo $thisArticle->NoLikes; ?></span>
        <button class="dislike-button" onclick="likeDislikeCounter(this)">Dislike</button>
        <span id="article-dislikes"><?php echo $thisArticle->NoDislike; ?></span>
      </div>


      <!-- COMMENT SECTION AND LEAVING REVIEWS -->
      <section>
        <h3>Comments</h3>
        <ul class="comment-list" style="list-style-type: none;">
          <?php 
            $comment = new Comment();
            $comments = $comment->getAllComments($id);
            foreach ($comments as $comm)
            {
                $commentCreator = $comm->getCommentCreator();
                $date = $comm->getCommentDate();
                $text = $comm->getCommentText();
                
                echo "<li>
                        <article class=\"comment\">
                            <header>
                                <h4>$commentCreator</h4>
                                <time datetime=\"2023-05-01T10:30:00\">$date</time>
                            </header>
                            <p>$text</p>
                        </article>
                      </li>";
            }
          ?>
        </ul>

        <!-- HIDE WITH PHP UNTIL USER LOGS IN -->
        <section <?php echo $hide;?>>
            <h3>Leave a Review</h3>
            <form method="POST">
              <label for="review">Review:</label>
              <textarea id="review" name="review" rows="4" cols="50" required></textarea>
              <input type="submit" value="Submit">
            </form>
        </section>
      </section>


  </main>
</body>

</html>