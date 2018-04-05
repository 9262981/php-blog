<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	session_start();//验证码生成session开始	 
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	//title.inc 定义样式选择
	define('SCRIPT','member');
	if(isset($_COOKIE['username'])){
			//获取数据
			$_rows=_fetch_array("
				SELECT user_username,user_sex,user_face,user_email,user_url,user_qq,user_level,user_reg_time,user_switch,user_autograph 
				FROM pppf_user 
				WHERE user_username='{$_COOKIE['username']}' 
				LIMIT 1
				");
			if($_rows){
				/* $_username=$_rows['user_username'];
				$_sex=$_rows['user_sex']; 太多变量不容易记，创建数组处理*/
				$_html=array();
				$_html['username']=$_rows['user_username'];
				$_html['sex']=$_rows['user_sex'];
				$_html['face']=$_rows['user_face'];
				$_html['email']=$_rows['user_email'];
				$_html['url']=$_rows['user_url'];
				$_html['qq']=$_rows['user_qq'];
				$_html['regtime']=$_rows['user_reg_time'];
				$_html['switch']=$_rows['user_switch'];
				$_html['autograph']=$_rows['user_autograph'];
				switch($_rows['user_level']){
					case 	0:
						$_html['level']='普通会员';
						break;
					case 1:
						$_html['level']='管理员';
						break;
					default :
						$_html['level']='出错了';
				}
				$_html=_html($_html);
				
				
			}else{
				_alert_back('此用户不存在');
			}
		
			}else{
			_location('非法登陆','login.php');}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?=$_system['webname']?>-个人中心</title>
<?php
		require ROOT_PATH."/includes/title.inc.php";
	?>

	   
</head>
<body>
	<?php
		require ROOT_PATH."/includes/header.inc.php";
	?>
	<div id="list">
		<div class="articlelist">
		会员管理中心
		</div>
		<div class="sidebar">
			<dt><span>用户名:</span><p><?php echo $_html['username'];?></p> </dt>
			<dt><span>性别:</span><p><?php echo $_html['sex'];?></p> </dt>
			<dt><span>头像:</span><p><?php echo $_html['face'];?></p> </dt>
			<dt><span>电子邮件: </span><p><?php echo $_html['email'];?></p> </dt>
		
			<dt><span>主页:</span><p><?php echo $_html['url'];?></p> </dt>
			<dt><span>QQ:</span><p><?php echo $_html['qq'];?></p> </dt>
			<dt><span>注册时间:</span><p><?php echo $_html['regtime'];?></p> </dt>
			<dt><span>身份:</span><p><?php echo $_html['level'];?></p> </dt>
			<dl><span>个性签名:</span><p><?php echo $_html['autograph'];?></p> </dl>
			
		</div>
	</div>
<?php
		require ROOT_PATH."/includes/member.inc.php";
	?>
	
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>