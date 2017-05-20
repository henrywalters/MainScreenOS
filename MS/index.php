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
//mice will look like {user1:MouseObj,user2:MouseObj}
var client_mice = {};
var m_x = 0;
var m_y = 0;
var mouse = new Mouse('mouse-<?php echo $user_id; ?>',0,0,'black');

$(document).ready(function(){
	$(document).mousemove(function(event){
		m_x = event.pageX;
		m_y = event.pageY;
		mouse.move(m_x,m_y);
		mouse.draw();
		$.get('socketFunctions/sendMousePos.php',{'m_x':m_x,'m_y':m_y},function(data){

		})
	});
	//17 MS for 60 FPS, 34 for 30FPS
	window.setInterval(function(){
		$.get('socketFunctions/getMousePos.php',function(data){
			console.log(data);
			if (typeof data != "undefined"){
				parseCmd(data);
			}
		});
	},34);
});

function parseCmd(cmd){
	cmds = cmd.split("$");
	for (var i = 0; i < cmds.length; i++){
		var command = cmds[i].split(":");
		cmd = command[0];
		var object = command[1];
		var user = command[2];
		var params = ((params)?command[3].split(","):"");

		if (cmd == "mouseCoords"){
			if (client_mice.hasOwnProperty(user) == false){
				client_mice[user] = new Mouse('mouse-'+user,params[0],params[1],'green');
				client_mice[user].draw();
			} else {
				client_mice[user].move(parseInt(params[0]),parseInt(params[1]));
				client_mice[user].draw();
			}
		}
	}
}

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