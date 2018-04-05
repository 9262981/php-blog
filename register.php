<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	session_start();//验证码生成session开始	
	define ('pppf',true);//外部调用定义	pppf
	require dirname(__FILE__).'/includes/common.inc.php';/* 转换为硬路径，速度更快一些 */
	define('SCRIPT','reg');//css选择
	_login_state();
	//判断是否提交了
	 if(@$_GET['action']=='register'){
		if($_system['register']==0){
			exit('请勿非法注册');
		}
	//为了防止恶意注册，跨站攻击,验证码判断
	_check_code(@$_POST['code'],$_SESSION['code']);
	//引入验证文件（在表达式里面最好用include*是在需要的时候引入*函数或者表达式里面都可以包含*）
	include ROOT_PATH."/includes/check.func.php";	
	//创建一个数组空数据，存放提交过来的 数据
	$_clean=array();
	//可以通过唯一标识符来防止恶意的注册，跨站攻击
	$_clean['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);		
	$_clean['active']= _sha1_uniqid();// active，也是唯一标识符，用来刚注册的用户激活处理否则无法登陆
	$_clean['username']=_check_username($_POST['username'],2,20);
	$_clean['password']=_check_password($_POST['password'],$_POST['notpassword'],6,18);
	$_clean['question']=_check_question($_POST['question'],2,20);
	$_clean['answer']=_check_answer($_POST['question'],$_POST['answer'],2,20);
	$_clean['sex']=_check_sex($_POST['sex']);
	$_clean['face']=_check_face($_POST['face']);
	$_clean['email']=_check_email($_POST['email'],6,30);
	$_clean['qq']=_check_qq($_POST['qq']);
	$_clean['url']=_check_url($_POST['url'],40);
	
	//在新增数据之前进行username判断是否重复
	// $query=_query("SELECT user_username FROM pppf_user WHERE user_username='{$_clean['username']}'");
	// if(mysql_fetch_array($query,MYSQL_ASSOC)){
		// _alert_back('对不起此用户名已经注册!');
	// }

	_is_repeat(
		"SELECT user_username FROM pppf_user WHERE user_username='{$_clean['username']}' LIMIT 1",
		'对不起此用户名已经被注册'
	);

	//在双引号里面可以直接放变量，但是如果放置数组需要加花括号，新增数据//
	 _query("INSERT INTO PPPF_USER (
									user_uniqid,
									user_active,
									user_username,
									user_password,
									user_question,
									user_answer,
									user_sex,
									user_face,
									user_email,
									user_qq,
									user_url,
									user_reg_time,
									user_last_time,
									user_last_ip
									)
							 VALUES (
									'{$_clean['uniqid']}', 
									'{$_clean['active']}',
									'{$_clean['username']}',
									'{$_clean['password']}',
									'{$_clean['question']}',
									'{$_clean['answer']}',
									'{$_clean['sex']}',
									'{$_clean['face']}',
									'{$_clean['email']}',
									'{$_clean['qq']}',
									'{$_clean['url']}',										
									NOW(),
									NOW(),
									'{$_SERVER["REMOTE_ADDR"]}'
									)"
								) ;
		if(_affected_rows()==1){
			$_clean['id']=_insert_id();
		   _close();
		   //_session_destroy();
		   //生成xml
		   _set_xml('new.xml',$_clean);
		   _location('恭喜注册成功！','active.php?active='.$_clean['active']);
		   }else{_close();
			   //_session_destroy();
		   _location('注册失败','register.php');} 
										
	 }else{
		 $_SESSION['uniqid']= $_uniqid = _sha1_uniqid();
	 }

	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?=$_system['webname']?>-注册</title>
<script type="text/javascript" src="assets/js/register.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>
<?php
	require ROOT_PATH."/includes/header.inc.php";
?>
	<div id="content" >
		<h2>会员注册</h2>
		<?php if($_system['register']==1){?>
		<form method="post" name="register" action="register.php?action=register" >
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
		<dl>
			<dt>请认真填写以下内容</dt>
				<dd>用 户 名：<input type="text" name="username" class="text" />*</dd>
				<dd>密&nbsp;&nbsp;&nbsp;&nbsp;码：<input type="password" name="password" class="text" />*</dd>
				<dd>确认密码：<input type="password" name="notpassword" class="text" />*</dd>
				<dd>_______________________________________</dd>
				<dd>密码提示：<input type="text" name="question" class="text" /></dd>
				<dd>密码回答：<input type="text" name="answer" class="text" /></dd>
				<dd>性&nbsp;&nbsp;&nbsp;&nbsp;别：&nbsp;&nbsp;
				<input type="radio" name="sex" value="男" checked="checked" />男&nbsp;&nbsp;
				<input type="radio" name="sex" value="女" />女</dd>
				<dd class="face">头像选择：&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="hidden" name="face" value="assets/img/face2/1.png" id="face" />
				<img src="assets/img/face2/1.png" alt="头像选择" id="faceimg"></dd>
				<dd>电子邮件：<input type="text" name="email" class="text" /></dd>
				<dd>&nbsp;&nbsp;Q&nbsp;&nbsp;Q&nbsp;&nbsp;：<input type="text" name="qq" class="text" /></dd>
				<dd>主页地址：<input type="text" name="url" class="text" value="" /></dd>
				<dd>验 证 码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                    <img src="code.php" class="yzmimg" id="code" /></dd>
				<dd><input type="submit" value="提交" class="submit" id="submit" /></dd>
		</dl>
		</form>
		<?php }else{?>
		<form method="post" name="register" action="register.php?action=register" >
			
		<dl>
			<dt>目前不允许开放注册</dt>
				
		</dl>
		</form>
		<?php }?>
	</div>
	
<?php
	require ROOT_PATH."includes/footer.inc.php";
?>

</body>
</html>