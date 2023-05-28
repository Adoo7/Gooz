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
if(isset($_GET['id']) && $_GET['id'] != '' && isset($_GET['search'])){
    $categoryID = urldecode($_GET['id']);
    $searchQuery = urldecode($_GET['search']);

    $result = $db->querySQL("SELECT * FROM Article JOIN User ON Article.UserID = User.UserID WHERE Article.CategoryID = $categoryID AND (Article.HeadLine LIKE '%$searchQuery%' OR User.UserName LIKE '%$searchQuery%' OR Article.ArticleText LIKE '%$searchQuery%')");
}
elseif (isset($_GET['startDate']) && isset($_GET['endDate']))
{
    $startDate = urldecode($_GET['startDate']);
    $endDate = urldecode($_GET['endDate']);
    $result = $db->querySQL("SELECT * FROM Article WHERE PublishDate BETWEEN '$startDate' and '$endDate' ORDER BY NoReaders DESC");
}
elseif (isset($_GET['recentNewsBtn'])) {
    // retrieve the most recent articles
    $result = $db->querySQL("SELECT * FROM Article ORDER BY PublishDate DESC");
}
elseif (isset($_GET['search'])) {
    // search query is present in URL, retrieve articles matching search query
    $searchQuery = urldecode($_GET['search']);
    $result = $db->querySQL("SELECT Article.* FROM Article LEFT JOIN User ON Article.UserID = User.UserID WHERE Article.HeadLine LIKE '%$searchQuery%' OR User.UserName LIKE '%$searchQuery%' OR Article.ArticleText LIKE '%$searchQuery%'");
} else {
    
    // no search query in URL, determine if user is in dashboard or has clicked a category
    $categoryID = urldecode($_GET['id']);
    if(empty($categoryID)) {
        //should be sorted by views OR likes
        $result = $db->querySQL("SELECT * FROM Article ORDER BY NoReaders DESC");

    } else {
        $result = $db->querySQL("SELECT * FROM Article WHERE CategoryID = $categoryID ORDER BY NoReaders Desc");
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
    <div>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
            <script>
              $(function() {
                $("#startDate").datepicker({
                  dateFormat: 'yy-mm-dd',
                  rangeSelect: true // enable date range selection
                });
                $("#endDate").datepicker({
                  dateFormat: 'yy-mm-dd',
                  rangeSelect: true // enable date range selection
                });
              });
            </script>
                    <form id="dateRangeForm" method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label for="startDate">Start Date:</label>
                    <input type="text" id="startDate" name="startDate" placeholder="Select Start Date: ">
                    <label for="endDate">End Date:</label>
                    <input type="text" id="endDate" name="endDate" placeholder="Select End Date: ">
                    <input type="hidden" name="id" value="<?php echo $categoryID ?>">
                    <button type="submit" id="dateRangeBtn">Search</button>
                  </form>

                  <script>
                    // add event listener to button
                    document.getElementById("dateRangeBtn").addEventListener("click", function() {
                      // retrieve start date
                      var startDate = document.getElementById("startDate").value;

                      if (startDate !== "") {
                        // add start date to URL
                        var url = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $categoryID ?>&startDate=" + startDate;

                        // set form action to new URL
                        document.getElementById("dateRangeForm").action = url;

                        // submit form withGET method
                        document.getElementById("dateRangeForm").submit();
                      }
                    });
                  </script>
  </div>
<?php
  
    echo '<div class= "col-12 row row-cols-1 row-cols-md-2 justify-content-around">';
    $counter=0;
    $darkbg=true;
    foreach ($articles as $article) {

        if($darkbg){
            echo '<div class="col-md-5 my-2 p-2 bg-grey border-0 rounded py-1 text-white">'.
            '<article>' .
            '<h3 class="text-center playball mb-0">' . $article->getHeadLine() . '</h3><hr class="border-white border-1 mt-0 mb-2">' .
            '<p>' . $article->getArticleText() . '</p>' .
            '<a class="link-light fst-italic" href="article.php?id='. $article->getArticleID(). '">Read more...</a>' .
            '</article></div>';

        } else {
            echo '<div class="col-md-5 my-2 p-2">'.
            '<article>' .
            '<h3 class="text-center playball mb-0">' . $article->getHeadLine() . '</h3><hr class="border-black border-1 mt-0 mb-2">' .
            '<p>' . $article->getArticleText() . '</p>' .
            '<a class="link-body-emphasis fst-italic" href="article.php?id='. $article->getArticleID(). '">Read more...</a>' .
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