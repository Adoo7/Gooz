<?php
//this script is called by AJAX using the GET method
$q = $_GET["q"];

include "Database.php";
include "user.php";


$user = new User();
$users = $user->searchUsers($q);

echo '<table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>';

foreach ($users as $user) {
        
$uid = $user->getUid();
$username = $user->getUsername();
$password = $user->getPassword();
$email = $user->getEmail();
$roleid = $user->getRoleID();
        
switch ($roleid) {
    case 3:
        $roleid = 'Admin';
        break;
    case 2:
        $roleid = 'Author';
        break;
    case 1:
        $roleid = 'Viewer';
        break;
    default:
        $roleid = 'undefined';
        break;
}

echo "<tr>
        <td>$uid</td>
        <td>$username</td>
        <td>$password</td>
        <td>$email</td>
        <td>$roleid</td>
        <td><a href=\"edit_user.php?id=$uid\"><button>edit</button></a></td>
        <td><button onclick=\"confirmDelete($uid)\">delete</button></td>
      </tr>";            
}

echo "</tbody></table>"
?>

