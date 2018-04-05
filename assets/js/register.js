
	//等网页加载完毕再执行
	window.onload = function(){
	code();
	var faceimg= document.getElementById('faceimg');
	
	faceimg.onclick =function(){
		window.open('face.php','face','width=350px,height=300px,top=300px,left=500px,scrollbars=1');
	};
	


	//表单验证-用户名验证
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
		if(fm.password.value!=fm.notpassword.value){
			alert('两次输入密码不一致');
			fm.notpassword.value='';//清空	
			fm.notpassword.focus();//将光标移动到username
			return false;
		}
		//密码提示验证与回答
		if(fm.question.value!=''){
		if((fm.question.value.length)<2||(fm.question.value.length)>20){
			alert('提示问题不得小于2位大于20位');
			fm.question.value='';//清空
			fm.question.focus();//将光标移动到username
			return false;
		}}
		//密码提示验证与回答
		if(fm.answer.value!=''){
		if((fm.answer.value.length)<2||(fm.answer.value.length)>20){
			alert('密码提示的答案不得小于2位大于20位');
			fm.answer.value='';//清空
			fm.answer.focus();//将光标移动到username
			return false;
		}}
		if(fm.question.value!=''){
		if(fm.question.value==fm.answer.value){
			alert('密码提示与密码答案不得相等');
			fm.answer.value='';//清空
			fm.answer.focus();//将光标移动到username
			return false;
		}}
		//邮件验证
		if(fm.email.value!=''){
		if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)){
			alert('请输入正确的email格式');
			// fm.email.value='';//清空
			fm.email.focus();//将光标移动到username
			return false;
		}
		}
		//qq号码
		if(fm.qq.value!=''){
		if(!/^[1-9]{1}[\d]{4,9}$/.test(fm.qq.value)){
			alert('请输入正确的qq号码');
			// fm.qq.value='';//清空
			fm.qq.focus();//将光标移动到username
			return false;
		}
		}
		//网址
		if(fm.url.value!=''){
		if(!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)){
			alert('网址不正确');
			fm.url.value='';//清空
			fm.url.focus();//将光标移动到username
			return false;
		}
		}
		//验证码
		if(fm.code.value.length!=4){
			alert('验证码需要4位');
			fm.code.value='';//清空
			fm.code.focus();//将光标移动到username
			return false;
		}
		return true;
	};
};