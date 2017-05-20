<?php


?>

<html>
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
<header>
<h3>MainScreen New Client</h3>
</header>
<body>

<h4>User Id: <input type='text' id='user_id'></h4>
<h4>Port: <input type='text' id='port'></h4>
<button onclick='connect()'>Connect</button>
<h5 style='color:red;display:none' id='error'>Connection Failed</h5>

</body>

</html>

<script>

function connect(){
	var user_id = document.getElementById("user_id").value;
	console.log(user_id);
	var port = document.getElementById('port').value;
	$.get('connectClient.php',{'user_id': user_id, 'port':port},function(data){
		console.log(data);
		if (data == "true"){
			window.location.href = "MS";
		} else {
			$('#error').show();
		}
	})
}

</script>