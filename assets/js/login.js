window.onload = function(){
	code();
var fm=document.getElementsByTagName('form')[0];
	fm.onsubmit = function(){
	//最好用客户端 的js 验证//	
		if((fm.username.value.length)<2||(fm.username.value.length)>20){
			alert('用户名不得小于2位大于20位');
			fm.username.value='';//清空
			fm.username.focus();//将光标移动到username
			return false;
		}
		if(/[<>\'\"\ \’\‘\“\”]/.test(fm.username.value)){
			alert('用户名不得包含非法字符');
			fm.username.value='';//清空
			fm.username.focus();//将光标移动到username
			return false;
		}
		//密码验证
		if((fm.password.value.length)<6){
			alert('密码不得小于6位');
			fm.password.value='';//清空	
			fm.password.focus();//将光标移动到username
			return false;
		}
		if(fm.code.value.length!=4){
			alert('验证码需要4位');
			fm.code.value='';//清空
			fm.code.focus();//将光标移动到username
			return false;
		}
		return true;
	};
	};