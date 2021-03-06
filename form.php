
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


function TextInput(container,id,style,label, label_id, label_style){
	this.container = container;
	this.id = id;
	this.style = style;


	this.html = "<label for='" + this.id + "' style='" + label_style +"' id='" + label_id + "'>" + label + "&nbsp;<input class='textInput' type='text' id='" + this.id + "' style='" + this.style + "'>";

	$('#'+this.container).append(this.html);
}

function TextArea(container,id,style,value){
	this.container = container;
	this.id = id;
	this.style = style;

	this.html = "<textarea spellcheck='false' id='" + this.id + "' style='position:relative;" + this.style + "' >" + value + "</textarea>";

	$('#' + this.container).append(this.html);
}

function Button(container,id,style,label){
	this.container = container;
	this.id = id;
	this.style = style;

	this.html = "<button id='" + this.id + "' style='" + this.style + "' onclick=compile('" + this.id + "')>" + label + "</button>";

	$('#' + container).append(this.html);
}

function IFrame(container,id,style,hr){
	this.html = "<iframe src='" + hr + "' id='" + id + "' style='" + style + "'></iframe>";
	$('#' + container).append(this.html);
}
</script>
