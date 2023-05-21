<?php

class Files {

    private $FileID;
    private $FileName;
    private $FileType;
    private $Flocation;
    private $ArticleID;
    
        function __construct() {
        $this->fid = null;
        $this->fname = null;
        $this->ftype = null;
        $this->flocation = null;
        $this->uid = null;
    }
    
    public function getFileID() {
        return $this->FileID;
    }

    public function getFileName() {
        return $this->FileName;
    }

    public function getFileType() {
        return $this->FileType;
    }

    public function getFlocation() {
        return $this->Flocation;
    }

    public function getAtricleID() {
        return $this->ArticleID;
    }

    public function setFileID($FileID) {
        $this->FileID = $FileID;
    }

    public function setFileName($FileName) {
        $this->FileName = $FileName;
    }

    public function setFileType($FileType) {
        $this->FileType = $FileType;
    }

    public function setFlocation($Flocation) {
        $this->Flocation = $Flocation;
    }

    public function setAtricleID($AtricleID) {
        $this->ArticleID = $AtricleID;
    }
    

    function deleteFile() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from files where fid=' . $this->FileID);
            unlink($this->Flocation);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

    function initWithFid($fid) {

        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM files WHERE fid = ' . $fid);
        $this->initWith($data->FileID, $data->FileName, $data->Flocation, $data->FileType, $data->ArticleID);
    }

    function addFile() {

        try {
            $db = Database::getInstance();
            $data = $db->querySql('INSERT INTO files (fid, ArticleID, fname, flocation, ftype) VALUES '
                    . '(NULL, ' . $this->ArticleID . ', \'' . $this->FileName . '\',\'' . $this->Flocation . '\',\'' . $this->FileType . '\')');
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

//    private function initWith($fid, $fname, $flocation, $ftype, $uid) {
//        $this->fid = $fid;
//        $this->fname = $fname;
//        $this->flocation = $flocation;
//        $this->ftype = $ftype;
//        $this->uid = $uid;
//    }

    function updateDB() {

        $db = Database::getInstance();
        $data = 'UPDATE files set
			fname = \'' . $this->FileName . '\' ,
			ftype = \'' . $this->FileType . '\' ,
			flocation = \'' . $this->Flocation . '\' ,
                        ArticleID = ' . $this->ArticleID . '
				WHERE fid = ' . $this->FileID;
        $db->querySql($data);
    }

    function getAllFiles() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from files');
        return $data;
    }

    function getArticleFiles() {
        $db = Database::getInstance();
        $data = $db->multiFetch('Select * from files where ArticleID=' . $this->ArticleID);
        return $data;
    }

}