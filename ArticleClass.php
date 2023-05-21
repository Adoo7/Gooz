<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Article {
    private $conn;
    private $table = 'Article';

    // Article properties
    public $ArticleID;
    public $HeadLine;
    public $ArticleText;
    public $PublishDate;
    public $Published;
    public $NoReaders;
    public $NoLikes;
    public $NoDislike;
    public $CategoryID;
    public $UserID;
    public $image;
    public $video;
    
    public function __construct() {
    }

    public function getVideo() {
        return $this->video;
    }
    
    public function setVideo($video) {
        $this->video = $video;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function setImage($image) {
        $this->image = $image;
    }
    
    public function getArticleID() {
        return $this->ArticleID;
    }

    public function setArticleID($ArticleID) {
        $this->ArticleID = $ArticleID;
    }

    public function getHeadLine() {
        return $this->HeadLine;
    }

    public function setHeadLine($HeadLine) {
        $this->HeadLine = $HeadLine;
    }

    public function getArticleText() {
        return $this->ArticleText;
    }

    public function setArticleText($ArticleText) {
        $this->ArticleText = $ArticleText;
    }

    public function getPublishDate() {
        return $this->PublishDate;
    }

    public function setPublishDate($PublishDate) {
        $this->PublishDate = $PublishDate;
    }

    public function getPublished() {
        return $this->Published;
    }

    public function setPublished($Published) {
        $this->Published = $Published;
    }

    public function getNoReaders() {
        return $this->NoReaders;
    }

    public function setNoReaders($NoReaders) {
        $this->NoReaders = $NoReaders;
    }

    public function getNoLikes() {
        return $this->NoLikes;
    }

    public function setNoLikes($NoLikes) {
        $this->NoLikes = $NoLikes;
    }

    public function getNoDislike() {
        return $this->NoDislike;
    }

    public function setNoDislike($NoDislike) {
        $this->NoDislike = $NoDislike;
    }

    public function getCategoryID() {
        return $this->CategoryID;
    }

    public function setCategoryID($CategoryID) {
        $this->CategoryID = $CategoryID;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function setUserID($UserID) {
        $this->UserID = $UserID;
    }
    
    // Get articles
    public function read() {
        // Create query
        $query = 'SELECT * FROM ' . $this->table;

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single article
    public function read_single($articleID) {

        $query = "SELECT * FROM Article WHERE ArticleID = $articleID";

        $db = Database::getInstance();
        $dbc = $db->connect();
        $result = $db->querySQL($query);
        
        
        // Set properties
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
            //Uncomment to find out what the query is returning
            //var_dump($row);
        }
        
        return $article;
    }
    
    public function test() {
        $i = 1;
        
        echo 'started test<br>';
        
        $db = Database::getInstance();
        $db->connect();
        $this->conn = $db->getDBCon();
        
        if ($sql = $this->conn->prepare("SELECT * FROM User WHERE UserID = ?")){
            $sql->bind_param("i",$i);
            $sql->execute();
            echo 'ran statement<br>';
            return true;
        } else {
            echo "Failed prepare statement" . $this->conn->error . $this->conn->error;
            return false;
        }
        
        echo 'finsihed test<br>';
    }

    // Create article
    public function create() {
        echo '<br>test line 172<br>';

        $db = Database::getInstance();
        $db->connect();
        $this->conn = $db->getDBCon();
        
        echo 'test line 177<br>';
        
        // Create query
        $query = "INSERT INTO Article(ArticleID, HeadLine,".
            "ArticleText, PublishDate, Published, NoReaders,".
            "NoLikes, NoDislike, CategoryID, UserID)". 
            "VALUES (NULL, ?, ?, NOW(), ?, 0, 0, 0, ?, ?)";

        echo 'test line 185<br>';
        // Prepare statement
        try {
        $stmt = $this->conn->prepare($query);
        echo 'query prepped<br>';
            // Rest of the code
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        echo 'test line 189<br>';
        
        echo 'test line 201<br>';
        // Bind data
        $stmt->bind_param("ssiii", $this->HeadLine, $this->ArticleText, $this->Published, $this->CategoryID, $this->UserID);
//        $stmt->bindParam(1, $this->HeadLine, PDO::PARAM_STR);
//        $stmt->bindParam(2, $this->ArticleText, PDO::PARAM_STR);
//        $stmt->bindParam(3, $this->Published, PDO::PARAM_INT);
//        $stmt->bindParam(4, $this->CategoryID, PDO::PARAM_INT);
//        $stmt->bindParam(5, $this->UserID, PDO::PARAM_INT);
//        
        echo 'test line 205';
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update article
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                SET
                    HeadLine = :HeadLine,
                    ArticleText = :ArticleText,
                    PublishDate = :PublishDate,
                    Published = :Published,
                    NoReaders = :NoReaders,
                    NoLikes = :NoLikes,
                    NoDislike = :NoDislike,
                    CategoryID = :CategoryID,
                    UserID = :UserID
                WHERE
                    ArticleID = :ArticleID';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->ArticleID = htmlspecialchars(strip_tags($this->ArticleID));
        $this->HeadLine = htmlspecialchars(strip_tags($this->HeadLine));
        $this->ArticleText = htmlspecialchars(strip_tags($this->ArticleText));
        $this->PublishDate = htmlspecialchars(strip_tags($this->PublishDate));
        $this->Published = htmlspecialchars(strip_tags($this->Published));
        $this->NoReaders = htmlspecialchars(strip_tags($this->NoReaders));
        $this->NoLikes = htmlspecialchars(strip_tags($this->NoLikes));
        $this->NoDislike = htmlspecialchars(strip_tags($this->NoDislike));
        $this->CategoryID = htmlspecialchars(strip_tags($this->CategoryID));
        $this->UserID = htmlspecialchars(strip_tags($this->UserID));

        // Bind data
        $stmt->bindParam(':ArticleID', $this->ArticleID);
        $stmt->bindParam(':HeadLine', $this->HeadLine);
        $stmt->bindParam(':ArticleText', $this->ArticleText);
        $stmt->bindParam(':PublishDate', $this->PublishDate);
        $stmt->bindParam(':Published', $this->Published);
        $stmt->bindParam(':NoReaders', $this->NoReaders);
        $stmt->bindParam(':NoLikes', $this->NoLikes);
        $stmt->bindParam(':NoDislike', $this->NoDislike);
        $stmt->bindParam(':CategoryID', $this->CategoryID);
        $stmt->bindParam(':UserID', $this->UserID);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete article
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE ArticleID = :ArticleID';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

                // Clean data
        $this->ArticleID = htmlspecialchars(strip_tags($this->ArticleID));

        // Bind data
        $stmt->bindParam(':ArticleID', $this->ArticleID);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    
    public function getPublishedArticles() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $userID = $_SESSION['UserID'];
        
        $result = $db->querySQL("SELECT * FROM Article WHERE UserID = $userID AND Published = 1");

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
        
        return $articles;
    }
    
    public function getUnPublishedArticles() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $userID = $_SESSION['UserID'];
        
        $result = $db->querySQL("SELECT * FROM Article WHERE UserID = $userID AND Published = 0");

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
        
        return $articles;
    }

    public function getAllPublishedArticles() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $userID = $_SESSION['UserID'];
        
        $result = $db->querySQL("SELECT * FROM Article WHERE Published = 1");

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
        
        return $articles;
    }
  
    public function getAllUnPublishedArticles() {
        $db = Database::getInstance();
        $dbc = $db->connect();
        $userID = $_SESSION['UserID'];
        
        $result = $db->querySQL("SELECT * FROM Article WHERE Published = 0");

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
        
        return $articles;
    }
    
}


