<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

class Category {
    private $CategoryID;
    private $CategoryName;
    
    public function __construct() {
        $this->CategoryName = null;
        $this->CategoryID = null;

    }
    
    public function getCategoryID() {
        return $this->CategoryID;
    }

    public function getCategoryName() {
        return $this->CategoryName;
    }

    public function setCategoryID($CategoryID) {
        $this->CategoryID = $CategoryID;
    }

    public function setCategoryName($CategoryName) {
        $this->CategoryName = $CategoryName;
    }

    
    function intWithId($id) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Category WHERE CategoryID = ' . $id);
        $this->initWith($data->CategoryID, $data->CategoryName);
    }    
    
    function intWithCname($cname) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM Category WHERE CategoryName = ' . $cname);
        $this->initWith($data->CategoryID, $data->CategoryName);
    } 
    
    function insertCategory($category){
        try {
            $db = Database::getInstance();
            $data = $db->querySql('INSERT INTO Category (CategoryID, CategoryName) VALUES '
                    . '(NULL, ' . $category . '\')');
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }
    
    function deleteCategory() {
        try {
            $db = Database::getInstance();
            $data = $db->querySql('Delete from Category where CategoryID=' . $this->CategoryID);
            return true;
        } catch (Exception $e) {
            echo 'Exception: ' . $e;
            return false;
        }
    }

}