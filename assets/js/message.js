window.onload = function(){
	code();
	var fm=document.getElementsByTagName('form')[0];
	fm.onsubmit=function(){
	//验证码
		if(fm.code.value.length!=4){
			alert('验证码需要4位');
			fm.code.value='';//清空
			fm.code.focus();//将光标移动到username
			return false;
		}
		if((fm.content.value.length)<3||(fm.content.value.length)>200){
			alert('内容必须大于3位，小于200位！！！');
		
			fm.content.focus();//将光标移动到username
			return false;
		}
	};
	
};