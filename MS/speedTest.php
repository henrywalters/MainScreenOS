<script>

function now(){
	var t = new Date();
	return t.getTime();
}

function Speed(){
	this.d = new Date();
	this.n = this.d.getTime();
	this.delta = 0;
}

Speed.prototype.tic = function(){
	this.n = this.d.getTime();
	this.delta = 0;
}

Speed.prototype.toc = function(){
	var cur = this.d.getTime();
	this.delta = cur - this.n;
	this.n = 0;
	return "Time Ellapsed: " + this.delta + "ms";
}

</script>