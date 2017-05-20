<?php

session_start();
if ($_SESSION['auth'] == false && ($_SERVER['PHP_SELF'] == '/MainScreenOS/MS' || $_SERVER['PHP_SELF'] == '/MainScreenOS/MS/index.php')){
	header("Location: ../");
}

?>