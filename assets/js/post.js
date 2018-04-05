window.onload = function () {
	code();
	var ubb = document.getElementById('ubb');
	var ubbimg = ubb.getElementsByTagName('img');
	var fm=document.getElementsByTagName('form')[0];
	var font=document.getElementById('font');
	var color=document.getElementById('color');
	var html=document.getElementsByTagName('html')[0];
	fm.onsubmit=function(){
		if((fm.title.value.length)<2||(fm.title.value.length)>40){
			alert('标题不得小于2位大于40位');
			fm.title.value='';//清空
			fm.title.focus();//将光标移动到username
			return false;
		}
		if((fm.content.value.length)<10){
			alert('内容不得小于10位');
			fm.content.value='';//清空
			fm.content.focus();//将光标移动到username
			return false;
		}
		if(fm.code.value.length!=4){
			alert('验证码需要4位');
			fm.code.value='';//清空
			fm.code.focus();//将光标移动到username
			return false;
		}
		
		return true;
	}

	var q=document.getElementById('q');
	var qa=q.getElementsByTagName('a');
	
	qa[0].onclick=function(){
		window.open('q.php?num=48&path=assets/img/qpic/1/','q','width=400,height=400,scrollbars=auto');
	}
	qa[1].onclick=function(){
		window.open('q.php?num=10&path=assets/img/qpic/2/','q','width=400,height=400,scrollbars=auto');
	}
	qa[2].onclick=function(){
		window.open('q.php?num=39&path=assets/img/qpic/3/','q','width=400,height=400,scrollbars=auto');
	}
	html.onmouseup=function(){
		font.style.display='none';
		color.style.display='none';
	}
	
	ubbimg[0].onclick=function(){
		font.style.display='block';
	}
	ubbimg[1].onclick=function(){
		content('[b][/b]')
	}
	ubbimg[2].onclick=function(){
		content('[i][/i]')
	}
	ubbimg[3].onclick=function(){
		content('[u][/u]')
	}
	ubbimg[4].onclick=function(){
		content('[s][/s]')
	}
	ubbimg[5].onclick=function(){
		color.style.display='block';
		fm.t.focus();
		
	}
	ubbimg[6].onclick=function(){
		var url=prompt('请输入网址','http://')
		if(url){
			if(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)){
		content('[url]'+url+'[/url]')}else{
			alert('网址不规范');
			}
		}
	}
	ubbimg[7].onclick=function(){
		var email=prompt('请输入E-mail','')
		if(email){
			if(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(email)){
		content('[email]'+email+'[/email]')}else{
			alert('邮件不规范');
			}
		}
	}
	ubbimg[8].onclick=function(){
		var img=prompt('请输入图片网址','');
		if(img){
		content('[img]'+img+'[/img]');
	}
	}
	ubbimg[9].onclick=function(){
		var flash=prompt('请输入flash网址','http://')
		if(flash){
			if(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/){
		content('[flash]'+flash+'[/flash]')}else{
			alert('网址不规范');
			}
		}
	}
	ubbimg[14].onclick=function(){
		fm.content.rows+=2;
	}
	ubbimg[15].onclick=function(){
		fm.content.rows+=-2;
	}
	function content(string){
		fm.content.value+=string;
	}
	fm.t.onclick=function(){
		showcolor(this.value);
	}
	/* fm.content.value='123'; */
};
	function font(size){
		document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]'
	};
	function showcolor(color){
		document.getElementsByTagName('form')[0].content.value+='[color='+color+'][/color]'
	}

	