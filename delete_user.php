<?php

include 'header.php';
//include './Database.php';
include './user.php';

$uid = urldecode($_GET['id']);

$user = new User();
$user->initWithUid($uid);

$user->deleteUser();

header("Location: dashboard.php");