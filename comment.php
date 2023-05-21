<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Comment {
    private $CommentID;
    private $CommentText;
    private $CommentDate;
    private $ArticleID;
    private $UserID;
    
    public function __construct() {
        $this->CommentID = null;
        $this->CommentText = null;
        $this->CommentDate = null;
        $this->ArticleID = null;
        $this->UserID = null;
    }
    
    public function getCommentID() {
        return $this->CommentID;
    }

    public function getCommentText() {
        return $this->CommentText;
    }

    public function getCommentDate() {
        return $this->CommentDate;
    }

    public function getArticleID() {
        return $this->ArticleID;
    }

    public function getUserID() {
        return $this->UserID;
    }

    public function setCommentID($CommentID) {
        $this->CommentID = $CommentID;
    }

    public function setCommentText($CommentText) {
        $this->CommentText = $CommentText;
    }

    public function setCommentDate($CommentDate) {
        $this->CommentDate = $CommentDate;
    }

    public function setArticleID($ArticleID) {
        $this->ArticleID = $ArticleID;
    }

    public function setUserID($UserID) {
        $this->UserID = $UserID;
    }

function intWithCid($cid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Comment WHERE CommentID = ' . $cid);
        $this->initWith($data->CommentID, $data->CommentText, $data->CommentDate, $data->ArticleID, $data->UserID);
    }
    
    function initWithArticleID() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Comment WHERE ArticleID = \'' . $this->ArticleID . '\'');
        if ($data != null) {
            return false;
        }
            return true;
    }
    
    function initWith($cid, $commenttext, $commentdate, $articleid, $userid){
        $this->CommentID = $cid;
        $this->CommentText = $commenttext;
        $this->CommentDate = $commentdate;
        $this->ArticleID = $articleid;
        $this->UserID = $userid;
    }

}