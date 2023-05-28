<?php
//   TODO: MAKE THIS A LIST OF TOP VIEWED ARTICLES
//     Create variable to store query
//     loop through query while changing details based on it

//include 'Database.php';
include './ArticleClass.php';

$categoryID = urldecode($_GET['id']);

$db = Database::getInstance();
$dbc = $db->connect();

//determining if user is in dashboard or has clicked a category
if(isset($_GET['id']) && isset($_GET['search'])){
    $categoryID = urldecode($_GET['id']);
    $searchQuery = urldecode($_GET['search']);
    
    $result = $db->querySQL("SELECT * FROM Article WHERE CategoryID = $categoryID AND (HeadLine LIKE '%$searchQuery%' OR ArticleText LIKE '%$searchQuery%')");
}
elseif (isset($_GET['search'])) {
    // search query is present in URL, retrieve articles matching search query 
    $searchQuery = urldecode($_GET['search']);
    $result = $db->querySQL("SELECT * FROM Article WHERE HeadLine LIKE '%$searchQuery%' OR ArticleText LIKE '%$searchQuery%'");
} else {
    
    // no search query in URL, determine if user is in dashboard or has clicked a category
    $categoryID = urldecode($_GET['id']);
    if(empty($categoryID)) {
        //should be sorted by views OR likes
        $result = $db->querySQL("SELECT * FROM Article ORDER BY NoReaders DESC");

    } else {
        $result = $db->querySQL("SELECT * FROM Article WHERE CategoryID = $categoryID ORDER BY NoReaders DESC");
    }
}

if ($result) {
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {        
        // Process the results
    } else {
        echo "No results found.";
    }
} else {
    echo "Error executing query: " . mysqli_error($dbc);
}


foreach ($result as $row) {
    
    $article = new Article();
    $article->setArticleID($row['ArticleID']);
    $article->setHeadLine($row['HeadLine']);
    $article->setArticleText($row['ArticleText']);
    $article->setPublishDate($row['PublishDate']);
    $article->setPublished($row['Published']);
    $article->setNoReaders($row['NoReaders']);
    $article->setNoLikes($row['NoLikes']);
    $article->setNoDislike($row['NoDislike']);
    $article->setCategoryID($row['CategoryID']);
    $article->setUserID($row['UserID']);
    
    $articles[] = $article;
        
    //Uncomment to find out what the query is returning
    //var_dump($row);
}

?>

<section>
    <div class="d-flex p-1 justify-content-center">
        <h1 class="oldLondon fst-italic text-decoration-underline">Latest Article Releases</h1>
    </div>
<?php
  
    echo '<div class= "col-12 row row-cols-1 row-cols-md-2 justify-content-around">';
    $counter=0;
    $darkbg=true;
    foreach ($articles as $article) {

        if($darkbg){
            echo '<div class="col-md-5 my-2 p-2 bg-grey border-0 rounded py-1 text-white h-50 d-inline-block">'.
            '<article>' .
            '<h3 class="text-center playball mb-0">' . $article->getHeadLine() . '</h3><hr class="border-white border-1 mt-0 mb-2">' .
            '<p class="article-text main-page-article-text">' . $article->getArticleText() . '</p>' .
            '<div class="d-flex justify-content-around align-middle p-2">'.
            '<div class="col-6 d-flex gap-5"><a class="link-light fst-italic align-middle" href="article.php?id='. $article->getArticleID(). '">Read more...</a>'.$article->getPublishDate().'</div><p>'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                    <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                    </svg>'.
                    $article->getNoReaders().
                '</p><p class="col-1">'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                    </svg>'.
                    $article->getNoLikes().
                '</p><p class="col-1">'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down-fill" viewBox="0 0 16 16">
                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                    </svg>'.
                    $article->getNoDislike().
                '</p><p class="">'.
                    'by '.
                    '<span class="fw-bold">'.$article->getArticleCreator().'</span>'.
                '</p></div>'.'<span class="fw-bold">'.
            '</article></div>';

        } else {
            echo '<div class="col-md-5 my-2 p-2 h-50 d-inline-block">'.
            '<article>' .
            '<h3 class="text-center playball mb-0">' . $article->getHeadLine() . '</h3><hr class="border-black border-1 mt-0 mb-2">' .
            '<p class="article-text main-page-article-text">' . $article->getArticleText() . '</p>' .
            '<div class="d-flex justify-content-around align-items-center p-2">'.
            '<div class="col-6 d-flex gap-5"><a class="link-dark fst-italic align-middle" href="article.php?id='. $article->getArticleID(). '">Read more...</a>'.$article->getPublishDate().'</div><p>'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eyeglasses" viewBox="0 0 16 16">
                    <path d="M4 6a2 2 0 1 1 0 4 2 2 0 0 1 0-4zm2.625.547a3 3 0 0 0-5.584.953H.5a.5.5 0 0 0 0 1h.541A3 3 0 0 0 7 8a1 1 0 0 1 2 0 3 3 0 0 0 5.959.5h.541a.5.5 0 0 0 0-1h-.541a3 3 0 0 0-5.584-.953A1.993 1.993 0 0 0 8 6c-.532 0-1.016.208-1.375.547zM14 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                    </svg>'.
                    $article->getNoReaders().
                '</p><p class="col-1">'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                    <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a9.84 9.84 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733.058.119.103.242.138.363.077.27.113.567.113.856 0 .289-.036.586-.113.856-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.163 3.163 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.82 4.82 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                    </svg>'.
                    $article->getNoLikes().
                '</p><p class="col-1">'.
                    '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down-fill" viewBox="0 0 16 16">
                    <path d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.378 1.378 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51.136.02.285.037.443.051.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.896 1.896 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2.094 2.094 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.162 3.162 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.823 4.823 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591z"/>
                    </svg>'.
                    $article->getNoDislike().
                '</p><p class="">'.
                    'by '.
                    '<span class="fw-bold">'.$article->getArticleCreator().'</span>'.
                '</p></div>'.
            '</article></div>';
        }
        $darkbg = !$darkbg;
        $counter = $counter+1;
        if($counter==2){
            $counter=0;
            $darkbg  = !$darkbg;
        }
    }
    echo '</div>'

?>
</section>