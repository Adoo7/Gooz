<?php

include 'header.php';

if (isset($_POST['submitted'])) {

    if (!empty($_FILES)) {
        $upload = new Upload();
        $upload->setUploadDir('images/');
        $msg = $upload->upload('name');

        if (empty($msg)) {
            $file = new Files();
            $file->setFname($upload->getFilepath());
            $file->setFlocation($upload->getUploadDir() . $upload->getFilepath());
            $file->setFtype($upload->getFileType());
            $file->addFile();
        }else    print_r ($msg);
    }
    else
        echo '<p> try again';
}

echo '<h1> Upload Files </h1>';

echo '<div><form action="upload_files.php" method="post" enctype="multipart/form-data">
           <p><h1>Upload From</h1> 
        <p>
           <p>File   <input type="file" name="name" /></p>
        </p>
        <p><input type="submit" name="submit" value="Upload" /></p>
        
         <input type ="hidden" name="submitted" value="TRUE">
         </form></div>';


// list files here
$files = new Files();
$row = $files->getAllFiles();

if (!empty($row)) {
    echo '<br />';
    //display a table of results
    echo '<table align="center" cellspacing = "2" cellpadding = "4" width="75%">';
    echo '<tr bgcolor="#87CEEB">
          <td><b>Edit</b></td>
          <td><b>Delete</b></td>
          <td><b>File Name</b></td>
          <td><b>File Type</b></td>
          </tr>';


    $bg = '#eeeeee';

    for ($i = 0; $i < count($row); $i++) {
        $bg = ($bg == '#eeeeee' ? '#ffffff' : '#eeeeee');

        echo '<tr bgcolor="' . $bg . '">
             <td><a href="edit_file.php?fid=' . $row[$i]->fid . '">Edit</a></td>
             <td><a href="delete_file.php?fid=' . $row[$i]->fid . '">Delete</a></td>
             <td><a target="_blank" href="view_file.php?fid=' . $row[$i]->fid . '">' . $row[$i]->fname . '</a></td>
             <td>' . $row[$i]->ftype . '</td>
             </tr>';
    }
    echo '</table>';
} else {
    echo '<p class="error">' . $q . '</p>';
    echo '<p class="error">No files are uploaded yet</p>';
    echo '<p class="error">' . mysqli_error($dbc) . '</p>';
}


?>
