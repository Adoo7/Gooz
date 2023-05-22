<?php



include 'header.php';

$fid = $_GET['fid'];
if (empty($fid))
    $fid = $_POST['fid'];

$file = new Files();
$file->initWithFid($fid);

if (isset($_POST['submitted'])) {

    if (!empty($_FILES)) {
        $upload = new Upload();
        $upload->setUploadDir('images/');
        $msg = $upload->upload('name');
        
        if (empty($msg)) {
            $file = new Files();
            $file->initWithFid($fid);
            
            unlink($file->getFlocation());
            
            
            $file->setFname($upload->getFilepath());
            $file->setFlocation($upload->getUploadDir() . $upload->getFilepath());
            $file->setFtype($upload->getFileType());
            $file->updateDB();
            
            
        }
    }
    else
        echo '<p> try again';
}



echo '<h1> Edit Files </h1>';

echo '<div><form action="" method="post" enctype="multipart/form-data">
           <p><h1>Upload From</h1> 
           <p>
           <p>Old File: '.$file->getFname().'</p>
        <p>
           <p>New File   <input type="file" name="name" /></p>
        </p>
        <p><input type="submit" name="submit" value="Upload" /></p>
        
        <input type ="hidden" name="fid" value="'.$fid.'">
         <input type ="hidden" name="submitted" value="TRUE">
         </form></div>';




?>
