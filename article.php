<?php
    
    include 'header.php';
    include './Database.php';
    include './user.php';
    include 'ArticleClass.php';
    $article = new Article();
    $id = urldecode($_GET['id']);
    
    $thisArticle = $article->read_single($id); 
    $text = $thisArticle->getArticleText();
    $title = $thisArticle->getHeadLine();
    
?>
<html>
    
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <main>
    <header class="article-header">
      <h2><?php echo $title; ?></h2>
      <p class="meta">Published on May 1, 2023 by John Doe</p>
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
      <div>
        <button class="like-button" onclick="likeArticle()">Like</button>
        <span id="article-likes">0</span>
        <button class="dislike-button" onclick="dislikeArticle()">Dislike</button>
        <span id="article-dislikes">0</span>
      </div>


      <!-- COMMENT SECTION AND LEAVING REVIEWS -->
      <section>
        <h3>Comments</h3>
        <ul class="comment-list" style="list-style-type: none;">
          <li>
            <article class="comment">
              <header>
                <h4>User123</h4>
                <time datetime="2023-05-01T10:30:00">May 1, 2023 at 10:30am</time>
              </header>
              <p>This is a great article!</p>
              <!-- LIKE/DISLIKE FOR COMMENT -->
              <div>
                <button class="like-button" onclick="likeComment(this)">Like</button>
                <span class="comment-likes">0</span>
                <button class="dislike-button" onclick="dislikeComment(this)">Dislike</button>
                <span class="comment-dislikes">0</span>
              </div>
            </article>
          </li>
          <li>
            <article class="comment">
              <header>
                <h4>User456</h4>
                <time datetime="2023-05-01T11:00:00">May 1, 2023 at 11:00am</time>
              </header>
              <p>I disagree with the author's points.</p>
              <!-- LIKE/DISLIKE FOR COMMENT -->
              <div>
                <button class="like-button" onclick="likeComment(this)">Like</button>
                <span class="comment-likes">0</span>
                <button class="dislike-button" onclick="dislikeComment(this)">Dislike</button>
                <span class="comment-dislikes">0</span>
              </div>
            </article>
          </li>
        </ul>

        <!-- HIDE WITH PHP UNTIL USER LOGS IN -->
        <h3>Leave a Review</h3>
        <form>
          <label for="review">Review:</label>
          <textarea id="review" name="review" rows="4" cols="50" required></textarea>
          <input type="submit" value="Submit">
        </form>
      </section>


  </main>
</body>

</html>