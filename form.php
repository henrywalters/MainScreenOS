<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<html>
<div id = "form"> </div>
</html>

<script>
function Form(id,x,y,title,h,w,color){
	this.id = id;
	this.x = ((x)?x:0);
	this.y = ((y)?y:0);
	this.title = title;
	this.h = ((h)?h:200);
	this.w = ((w)?w:200);
	this.color = ((color)?color: 'white');
	$('#form').draggable();

}

Form.prototype.draw = function (){
	var html = "<div class='container' id='" + this.id + "' style='border:1px solid black;position:absolute;background-color:" + this.color + ";height:" + this.h + "px;width:" + this.w + "px;top:" + this.y + "px;left:" + this.x + "px'>";
	html += "<header style='border: 1px solid black;position:relative;top:20px;background-color: gray;'> </header>"
	html += "</div>";
	$('#form').append(html);
}

var form = new Form('sublimeClone','100','100','newWindow');

form.draw();
</script>
