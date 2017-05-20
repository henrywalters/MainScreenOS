
<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script>

function Mouse (id,x,y,color) {
	this.id = id;
	this.x = ((x)?x:0);
	this.y = ((y)?y:0);
	this.coords = {x:this.x, y:this.y};
	this.color = ((color)?color: 'black');
	this.html = "<div style ='position:absolute;height:20px;width:20px;background-color:" + this.color + ";top:" + this.y + "px;left:" + this.x + "px' id='" + this.id + "'></div>";
	$('body').append(this.html);
}

Mouse.prototype.coords = function(){
	return this.coords;
}

Mouse.prototype.move = function(x,y){
	this.x = x;
	this.x = y;
	$('#' + this.id).css('left',x + 'px');
	$('#' + this.id).css('top',y + 'px')
	this.coords = {x:this.x,y:this.y};
}

Mouse.prototype.draw = function(){
	$('#' + this.id).html(this.html);
}


</script>