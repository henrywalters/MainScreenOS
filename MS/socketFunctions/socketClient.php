<?php
session_start();
$PORT = $_SESSION['port']; //the port on which we are connecting to the "remote" machine
$HOST = "141.217.175.129";//$_GET['host']; //the ip of the remote machine (in this case it's the same machine)
$user_id = $_SESSION['user_id'];

$sock = socket_create(AF_INET, SOCK_STREAM, 0) //Creating a TCP socket
		or die("error: could not create socket\n");

$succ = socket_connect($sock, $HOST, $PORT) //Connecting to to server using that socket
		or die("error: could not connect to host\n");


?>