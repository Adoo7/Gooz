<?php

?>
<html>

<head>
  <meta charset="utf-8">
  <title>Article Title</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <h1 class="logo">IT Newsletter</h1>
    <nav class="main-nav">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <header class="article-header">
      <h2>Article Title</h2>
      <p class="meta">Published on May 1, 2023 by John Doe</p>
    </header>
    <div class="wrapper">
      <article>

        <div class="content">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel turpis euismod, bibendum odio sit amet,
            consectetur nulla. Donec posuere auctor augue, ac tristique nisl accumsan nec. Integer at dolor eget augue
            sodales scelerisque. Nulla facilisi. Aliquam non enim sit amet nibh elementum ultrices. Fusce at convallis
            quam, nec tempor velit. Donec aliquet augue et convallis aliquet. Suspendisse quis nulla vitae turpis
            blandit blandit. Curabitur imperdiet metus quis risus eleifend laoreet. </p>
          <img src="https://via.placeholder.com/500x300" alt="Article Image">
          <p>Curabitur congue nunc eget metus maximus malesuada. Aliquam nec est euismod, dignissim nisl in, vulputate
            justo. Integer a velit ut ipsum vehicula pharetra at at nisi. Praesent malesuada erat sed commodo tempor. In
            ut justo a dolor pellentesque dapibus. Donec commodo lacus ut leo eleifend, vel convallis odio commodo.
            Etiam in odio euismod, vestibulum lectus ut, fermentum turpis. Sed vel est erat. </p>
          <audio src="https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_5MG.mp3" controls></audio>
          <p>Vivamus semper quam sed ante efficitur, eget dapibus ex lacinia. Donec euismod elit non risus rhoncus
            molestie. In eleifend eget enim vel mattis. Pellentesque habitant morbi tristique senectus et netus et
            malesuada fames ac turpis egestas. Quisque vitae turpis ac enim convallis ultrices. Nunc id enim id odio
            aliquet ultricies. </p>
          <video src="https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_640_3MG.mp4"
            controls></video>
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