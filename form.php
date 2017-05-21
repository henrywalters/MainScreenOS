<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<html>
<div id = "form"> </div>
<style>

</style>
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
	var html = "<div class='container' id='" + this.id + "' style='border:2px solid #34495e;position:absolute;background-color:" + this.color + ";height:" + this.h + "px;width:" + this.w + "px;top:" + this.y + "px;left:" + this.x + "px'>";
	html += "<header id='formHeader'style='border-bottom: 2px solid #34495e;background-color: #95a5a6;position:relative;bottom:20px;'><h2 style='height:10px;'></h2><div id='closeForm-" +this.id+ "' class='closeForm'style='float:right;position:relative;bottom:25px;right:5px;font-family:arial;'>x</div></header>"
	html += "</div>";
	$('#form').append(html);
}

var form = new Form('sublimeClone','100','100','newWindow');

form.draw();
</script>
