<?php

session_start();

$user_id = $_SESSION['user_id'];
$port = $_SESSION['port'];
$host = $_SESSION['host'];

include '../secure.php';
include '../cursor.php';
include 'speedTest.php';
include '../form.php';


?>


<html>
<head>
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body>
	<div id='OS'>
		<div id='ProgramMenu'>
			<div class='ProgramMenuItem' id='ProgramMenuTerminal' onclick='openTerminal()'><h3>Terminal</h3></div>
			<div class='ProgramMenuItem' id='ProgramMenuTerminal' onclick='openCoCompiler()'><h3>CoCompile</h3></div>
		</div>
	</div>
</body>

<footer>
	<div id='taskbar'>
		<div id='ProgramMenuIcon' class='togglable' style='height:100%;width:50px;background-color:gray' onclick="toggleProgramMenu()"></div>
	</div>
</footer>

</html>


<script>

var timer = new Speed();

var clients = [];
//mice will look like {user1:MouseObj,user2:MouseObj}
var client_mice = {};
var m_x = 0;
var m_y = 0;

var fps = 30;
var ms = Math.ceil(1000/fps);

var terminals = [];

var compilers = [];

var terminal_count = 0;

var compiler_count = 0;


console.log(ms);

var mouse = new Mouse('mouse-<?php echo $user_id; ?>',0,0,'black');

var last_move = 0;

$(document).ready(function(){
	$(document).mousemove(function(event){
		m_x = event.pageX + 1;
		m_y = event.pageY + 1;
		mouse.move(m_x,m_y);
		//mouse.draw();
		var delta = now() - last_move;
		if (delta > ms){
			$.get('socketFunctions/sendMousePos.php',{'m_x':m_x,'m_y':m_y});
			last_move = now();
		}
	});
	//17 MS for 60 FPS, 34 for 30FPS
	window.setInterval(function(){
		$.get('socketFunctions/getMousePos.php',function(data){
			parseCmd(data);

		});
	},ms);

	window.setInterval(function(){
		$.get('socketFunctions/readCommands.php',function(data){
			parseCmd(data);
		});
	},ms)

});

function toggleProgramMenu(){
	console.log("clicked");
	var menu = $('#ProgramMenu');
	if (menu.css('display') == 'none'){
		//menu.css('display','block');
		$.get('socketFunctions/open',{'object_id':'ProgramMenu'});
	} else {
		//menu.css('display','none');
		$.get('socketFunctions/close',{'object_id':'ProgramMenu'});
	}
}

function openTerminal(){
	$.get('socketFunctions/openForm',{'form_id':'terminal-' + terminal_count});
	
}

function openCoCompiler(){
	$.get('socketFunctions/openForm',{'form_id':'compiler-' + compiler_count});
	
}

function closeForm(form_id){
	$.get('socketFunctions/closeForm',{'form_id':form_id});
}

function parseCmd(cmd){
	cmds = cmd.split("$");
	timer.tic();
	for (var i = 0; i < cmds.length; i++){
		var command = cmds[i].split(":");
		cmd = command[0];
		var object = command[1];
		var user = command[2];
		if (typeof command[3] != "undefined"){
			var params = command[3].split(',');
		}
		else {
			var params = "";
		}

		if (cmd == "mouseCoords"){
			if (client_mice.hasOwnProperty(user) == false){
				client_mice[user] = new Mouse('mouse-'+user,params[0],params[1],'green');
				//client_mice[user].draw();
			} else {
				client_mice[user].move(parseInt(params[0]),parseInt(params[1]));
				//client_mice[user].draw();
			}
		}

		if (cmd == "open"){
			$('#' + object).show();
		} 

		if (cmd == "close"){
			$('#' + object).hide();
		}

		if (cmd == 'openForm'){
			if (params[0].indexOf('terminal') != -1){
				console.log(cmds);
				terminals.push(new Form(params[0],300,300,"Terminal", 150,350,'green'));
				terminals[terminal_count].draw();
				terminal_count += 1;
			}

			if (params[0].indexOf('compiler') != -1){
				compilers.push(new Form(params[0],400,100,"CoCompiler",400,350,"white"));
				compilers[compiler_count].draw();
				compiler_count += 1;
			}
		}

		if (cmd == 'closeForm'){
			if (params[0].indexOf('terminal') != -1){
				var index = params[0].split('-')[1];
				$('#' + params[0]).remove();
				terminals.pop(index);
				terminal_count -= 1;
			}

			if (params[0].indexOf('compiler') != -1){
				var index = params[0].split('-')[1];
				$('#' + params[0]).remove();
				compilers.pop(index);
				compiler_count -= 1;
			}
		}
	}
}

</script>


<style>


* { cursor: none; }

#OS{
	height:95%;
	width:100%;
	position:relative;
}

#ProgramMenu{
	bottom:0;
	border:1px solid black;
	height:auto;
	width:200px;
	position:absolute;
}

.ProgramMenuItem{
	width:100%;
	border-top:1px solid black;
	border-bottom:1px solid black;
	text-align:center;
}

#taskbar{
	height:5%;
	width:100%;
	background-color:#c4c4c4;
}

.hoverIcon:hover{
	background-color:#2d2d2d;
}

</style>