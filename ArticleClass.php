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

    
    public function __construct() {
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
    public function read_single() {
        // Create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE ArticleID = ?';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->ArticleID);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->HeadLine = $row['HeadLine'];
        $this->ArticleText = $row['ArticleText'];
        $this->PublishDate = $row['PublishDate'];
        $this->Published = $row['Published'];
        $this->NoReaders = $row['NoReaders'];
        $this->NoLikes = $row['NoLikes'];
        $this->NoDislike = $row['NoDislike'];
        $this->CategoryID = $row['CategoryID'];
        $this->UserID = $row['UserID'];
    }

    // Create article
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
                SET
                    HeadLine = :HeadLine,
                    ArticleText = :ArticleText,
                    PublishDate = :PublishDate,
                    Published = :Published,
                    NoReaders = 0,
                    NoLikes = 0,
                    NoDislike = 0,
                    CategoryID = :CategoryID,
                    UserID = :UserID';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
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
}

