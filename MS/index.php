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

	$(document).keyup(function(event){
		var focused = $(':focus');
		var id = focused.attr('id').split('-');

		$.get('socketFunctions/writeTerminal.php',{'terminal_id':id,'query':focused.val()});

		if (event.keyCode == 13){
			var val = focused.val();
			var p = val.split(' ');
			if (p.length == 2 && (p[0] == 'cd' || p[0] == 'mkdir' || p[0] == 'ls')){
				var folder = p[1].split('/');
				var parent_path = [];
				var parent = "";
				var folderName = folder[folder.length-1];
				
				id = id[0] + '-' + id[1];
				for (var i = 0; i < folder.length-1; i++){
					if (folder[i] != ""){
						parent_path.push(folder[i]);
					}
				}
				$.get('socketFunctions/fileManager.php',{'parent_path':parent_path.join('/'),'folder_name':folderName,'file_cmd':p[0],'object_id':id},function(data){
					console.log(data);
					if (data == "true"){
						if (p[0] == 'cd'){
							var label = $('#' + id + '-label').html().split('~');
							var html = $('#' + id + '-label').html();
							html = html.slice(html.indexOf('<'));
							var new_label = label[0] + '~' + parent_path.join('/') + '/' + folderName + '/';
							
							$('#' + id + '-label').html(new_label+html);
							$('#' + id).focus();
						}
					}
				});
			}
			
		}
	});

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
		var command = cmds[i].slice(0,cmds[i].length).split(":");

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
		if (cmd != "mouseCoords" && cmd.length == 4){console.log(command);}
		if (cmd == 'openForm'){
			if (params[0].indexOf('terminal') != -1){
				
				terminals.push(new Form(params[0],300,300,"Terminal", 150,350,'green'));
				terminals[terminal_count].draw();
				new TextInput(params[0], params[0] + '-input', 'width:auto;background-color:green;border:0px solid black;position:relative','Shared:~/',params[0] + '-label','position:relative;top:80px');
				new TextArea(params[0],params[0] + '-output', 'width:90%;margin-left:5%;background-color:green;border:0px solid black;height:97px;bottom:55px');
				$('#' + params[0] + "-input").focus();
				terminal_count += 1;
			}

			if (params[0].indexOf('compiler') != -1){
				compilers.push(new Form(params[0],400,100,"CoCompiler",400,350,"white"));
				console.log(params[0]);
				
				compilers[compiler_count].draw();
				new TextArea (params[0],params[0] + '-code','width:90%;margin-left:5%;height:80%;bottom:40px');
				new Button (params[0],params[0] + '-compile','position:relative;text-align:center;bottom:30px;left:150px','compile');
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

		if (cmd == 'writeTerminal'){
			console.log("working");
			$('#' + object + "-input").html(params[0]);
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

input:focus {outline:0;}

h3 {
	font:console;
}

textarea {
   resize: none;
}

</style>