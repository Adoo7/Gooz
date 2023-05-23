<?php


include 'header.php';

$page_title = 'Delete User';



$id=0;

//the first time the page is displayed it is because it is from a hyper link so we use $_GET to 
//retrieve the parameter from the link
//Any time the page is shown after that it is because it has been submitted using the form
//so we then use $_POST to get the form data
if( isset($_GET['fid']) )
{
    $fid=$_GET['fid'];  
}
elseif(isset($_POST['fid']))
{
    $fid=$_POST['fid'];    
}
else
{
     echo '<p class="error"> Error has occured</p>';    
}


echo '<h1>Delete File</h1>';
//create a user object 
$file = new Files();
$file->initWithFid($fid);
//not we do not need to call the get() method as we do not need to populate the object
//we only need to call its delete() and getUserName() methods

if(isset($_POST['submitted']))
{
//test the value of the radio button    
    if(isset($_POST['sure']) && ($_POST['sure'] == 'Yes') ) //delete the record   
    {  
       if($file->deleteFile())
           echo '<p> User' .$file->getFname(). ' was deleted</p>'; 
    }//no confirmation
     else
       echo '<p> User '. $file->getFname(). '  deletion not confirmed</p>'; 
}
else //show form
{
    echo '<div id="stylized" class="myform"> 
        <form action="delete_file.php" method="post">
        <br />
        <h3>Name: '.$file->getFname() . '</h3></br>
        <label>Delete this file?</label> <br/><br/>
          <input type="radio" name="sure" value="Yes" /><label>Yes</label>
          <input type="radio" name="sure" value="No" checked="checked" /> <label>No</label>
          <input type="submit" class ="DB4Button" name="submit" value="Delete" />
        
         <input type ="hidden" name="submitted" value="TRUE">
         <input type ="hidden" name="fid" value="' . $fid . '"/>
         </form>
         <div class="spacer"></div>
         </div>';   

}


?>