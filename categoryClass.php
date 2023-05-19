<?php

class Category {
    public $categoryID;
    public $categoryName;
    
    public function construct (){
        
    }
    
    public function getCategoryID(){
        return $this->categoryID;
    }
    
    public function getCategoryName(){
        return $this->categoryName;
    }
    
    public function setCategoryID($id){
        $this->categoryID = $id;
    }
    
    public function setCategoryName($name){
        $this->categoryName = $name;
    }
    
    
    
}
