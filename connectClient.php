<?php

session_start();

$PORT = $_GET['port']; //the port on which we are connecting to the "remote" machine
$HOST = '10.0.0.18';
//$HOST = '10.0.0.18';
//$HOST = "141.217.175.129";//$_GET['host']; //the ip of the remote machine (in this case it's the same machine)
$user_id = $_GET['user_id'];


$text = "add client:null:null:{$user_id}";



$sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
		or die("error: could not create socket\n");

$succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
		or die("error: could not connect to host\n");

socket_write($sock, $text . "\n", strlen($text) + 1) //Writing the text to the socket
		or die("error: failed to write to socket\n");

$reply = socket_read($sock, 10000, PHP_NORMAL_READ) //Reading the reply from socket
		or die("error: failed to read from socket\n");

if (strcmp($reply,'success') == true){
	$_SESSION['auth'] = true;
	$_SESSION['port'] = $PORT;
	$_SESSION['host'] = $HOST;
	$_SESSION['user_id'] = $user_id;
	echo "true";
} else {
	echo "false";
}
?>