<?php
session_start();	//provide access to the current session

$_SESSION['validUser']='no';
session_unset();	//remove all session variables related to current session
session_destroy();	//remove current session

header('Location: eventHome.php', true, 301);
$conn = null;
exit();

?>