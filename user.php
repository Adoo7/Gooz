<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of User
 *
 * @author 201901579
 */
class User {
    //put your code here
    private $UserID;
    private $Username;
    private $Email;
    private $Password;
    private $RoleID;
    
    function _construct() {
        $this->UserID = null;
        $this->Username = null;
        $this->Email = null;
        $this->Password = null;
        $this->RoleID = null;
    }
    
    function setUid ($uid){
        $this->UserID = $uid;
    }
    
    function setUsername ($username){
        $this->Username = $username;
    }
    
    function setPasswpord ($password){
        $this->Password = $password;
    }
    
    function setEmail ($email){
        $this->Email = $email;
    }
    
    function getUid(){
        return $this->UserID;
    }
    
    function getUsername(){
        return $this->username;
    }
    
    function getPassword(){
        return $this->password;
    }
    
    function getEmail(){
        return $this->email;
    }
    
    function intWithUid($uid) {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM User WHERE UserID = ' . $uid);
        $this->initWith($data->UserID, $data->Username, $data->Password, $data->Email, $data->RoleID);
        echo 'fetched user with username ' . $this->Username;
    }
    
    function initWithUsername() {
        $db = Database::getInstance();
        $data = $db->singleFetch('SELECT * FROM User WHERE UserName = \'' . $this->Username . '\'');
        if ($data != null) {
            return false;
        }
            return true;
    }
    
    function initWith($uid, $username, $password, $email, $roleid){
        $this->UserID = $uid;
        $this->Password = $password;
        $this->Username = $username;
        $this->Email = $email;
        $this->RoleID = $roleid;
    }
    
    function registerUser(){
        if($this->isValid()) {
            try{
                Database::getInstance()->querySql('INSERT INTO User (UserID, UserName, Password, Email, RoleID)'. ' VALUES (NULL, '
                    . '\''   . $this->Username 
                    . '\',\'' . $this->Password 
                    . '\',\'' . $this->Email 
                    . '\',\'' . $this->RoleID . '\')');
                return true;
            } catch (Exception $ex) {
                echo 'Exception: ' . $ex;
                return false;
            }
        } else {
            echo 'this is invalid';
            return false;
        }
    }
     
    function updateDB() {
        if($this->isValid()) {
            Database::getInstance()->querySql('UPDATE User set '
                    . 'Email = \'' . $this->email .'\','
                    . 'UserName = \'' . $this->username . '\','
                    . 'Password = \'' . $this->password . '\''
                    . ' WHERE UserID = ' . $this->uid);
            echo 'update called';
        }
    }
    
    function deleteUser() {
        try {
            Database::getInstance()->querySql('Delete from User where UserID = ' .$this->UserID);
            return true;
        } catch (Exception $ex) {
            echo 'Error deleting: ' . $ex;
            return false;
        }
    }
    
    public function isValid() {
        $errors = true;
        
        if(empty($this->Username)) {
            $errors = false; 
        }
        else {
            if (!$this->initWithUsername()) {
                $errors = false;
            }
            
            if (empty($this->Email)) {
                $errors = false;
            }     
            if (empty($this->Password)) {
                $errors = false;
            }
            return $errors;
        }
    }
    
    function checkUser($username, $password) {
        $data = Database::getInstance()->singleFetch(
                'SELECT * FROM User WHERE UserName = \'' .$username
                .'\' AND Password = \'' .$password .'\'');
        $this->initWith($data->UserID, $data->UserName, $data->Password, $data->Email, $data->RoleID);
        echo 'check failed';
    }
    
    function login($username, $password) {
        
        try {
            
            if($this->UserID != null) {
                
                $this->checkUser($username, $password);
                $_SESSION['UserID'] = $this->getUid();
                $_SESSION['UserName'] = $this->getUsername();
                echo '<br>username: '.$username
                        .'password: '.$password;
                
                return true;
                
            } else {
                
                $error[] = 'Wrong username or password';
                return false;
            }
            
        } catch (Exception $ex) {
            $error[] = $ex->getMessage();
            
        }
     
        return false;
    }
    
    function logout() {
        $_SESSION['UserID'] = '';
        $_SESSION['UserName'] = '';
        
        session_destroy();
    }
    
}
