<?php

include "../Database.php";
include "../user.php";

$user = new User();
$user->setUid($_GET['id']);
$user->setUsername($_GET['name']);
$user->setPasswpord($_GET['pass']);
$user->setEmail($_GET['email']);
$user->setRoleID($_GET['roleid']);

$user->editUser($_GET['id']);

echo 'update successful';


