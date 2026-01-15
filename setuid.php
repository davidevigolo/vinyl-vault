<?php
// this is just for test purposes, to set the user id since the login has not been implemented yet
session_start();
$_SESSION['user_id'] = 1;
echo "User ID set to 1 for testing purposes.";
?>