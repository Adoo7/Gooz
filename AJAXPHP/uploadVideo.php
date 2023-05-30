<?php
include '../Database.php';
include '../Files.php';
include '../ArticleClass.php';
    
$db = Database::getInstance();
$dbc = $db->connect();

if(isset($_FILES['file']['name'])){
    
    /* Getting the article ID */
    $Aid = $_POST['id'];

    /* Getting file name */
    $filename = $_FILES['file']['name'];

    /* Location */
    $location = "../uploads/".$filename;

    /* Extension */
    $extension = strtolower(pathinfo($location,PATHINFO_EXTENSION));

    /* Allowed file extensions */
    $allowed_extensions = array("mp4"); //"avi", "mov", "wmv"

    $response = array();
    $status = 0;

    /* Check file extension */
    if(in_array($extension, $allowed_extensions)) {
        
        $q = "INSERT into files(`fid`,`ArticleID`,`fname`,`flocation`,`ftype`) VALUES(null,$Aid,'$filename','uploads/','$extension');";
        $r = $db->querySQL($q);
        
        $q = 'SELECT LAST_INSERT_ID() as id;';
        $r = $db->querySQL($q);
        
        foreach ($r as $row){
            $id = $row['id'];
        }
        
        /* Changing file name */
        $filename = $id.'-'.$_FILES['file']['name'];
        
        /* changing location */
        $location = "../uploads/".$filename;
        
        /* Upload file */
        if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                
            $location = "uploads/".$filename;
                
            $status = 1;
            $response['path'] = $location;
            $response['extension'] = $extension;

        }
    }

    $response['status'] = $status;

    echo json_encode($response);
    exit;
}

echo 0;
