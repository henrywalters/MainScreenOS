<?php

session_start();
if ($_SESSION['auth'] == false && ($_SERVER['PHP_SELF'] == '/MainScreenOS/MS' || $_SERVER['PHP_SELF'] == '/MainScreenOS/MS/index.php')){
	header("Location: ../");
}

if ($_SERVER['PHP_SELF'] == 'MainScreenOS' || $_SERVER['PHP_SELF'] == 'MainScressOS/index.php'){
	session_destroy();
}

?>