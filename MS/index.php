<?php

session_start();

$user_id = $_SESSION['user_id'];
$port = $_SESSION['port'];
$host = $_SESSION['host'];

include '../secure.php';
include '../cursor.php';



?>


<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
</head>

<body>
	<div id='OS'>
	</div>
</body>

<footer>
	<div id='taskbar'>

	</div>
</footer>

</html>


<script>

var clients = [];
var client_mice = [];
var m_x = 0;
var m_y = 0;
var mouse = new Mouse('mouse-<?php echo $user_id; ?>',0,0,'black');

$(document).ready(function(){
	$(document).mousemove(function(event){
		m_x = event.pageX;
		m_y = event.pageY;
		mouse.move(m_x,m_y);
		mouse.draw();
	})
});

</script>


<style>

* {cursor: none;}

#OS{
	height:95%;
	width:100%;
}

#taskbar{
	height:5%;
	width:100%;
	background-color:#c4c4c4;
}

</style>