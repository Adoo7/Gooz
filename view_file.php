<?php

include 'header.php';

$fid = $_GET['fid'];
$file = new Files();
$file->initWithFid($fid);

if (file_exists($file->getFlocation())) {
    if($file->getFlocation() == 'image'){
        print $file;
    }else if ($file->getFlocation() == 'video'){
        echo '<video width="100%" controls>
              <source src="'.$file.'" type="video/mp4">
              </video>';
    }
    exit;
} else {
    echo '<p class="error"> Oh dear. There was a databse error</p>';
    
}