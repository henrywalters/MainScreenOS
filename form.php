
<script>
function Form(id,x,y,title,h,w,color){
	this.id = id;
	this.x = ((x)?x:0);
	this.y = ((y)?y:0);
	this.title = title;
	this.h = ((h)?h:200);
	this.w = ((w)?w:200);
	this.color = ((color)?color: 'white');

}

Form.prototype.draw = function(){
	var html = "<div class='container' id='" + this.id + "' style='border:2px solid #34495e;position:absolute;background-color:" + this.color + ";height:" + this.h + "px;width:" + this.w + "px;top:" + this.y + "px;left:" + this.x + "px'>";
	html += "<header id='formHeader' style='height:20px;border-bottom: 2px solid #34495e;background-color: #95a5a6;position:relative;bottom:20px'><h3 style'height:10px;'>" + this.title + "</h3><div id='closeForm-" + this.id + "' class='closeForm' style='float:right;position:relative;bottom:40px;right:5px;font-family:arial;width:20px' onclick=closeForm('" + this.id + "')>x</div></header>";
	html += "</div>";
	$('#OS').append(html);
	$('.container').draggable();
}

</script>
