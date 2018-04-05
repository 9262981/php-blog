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
	define('SCRIPT','manage');
	//必须是管理员才能登录
	_manage_login();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?=$_system['webname']?>-后台管理中心</title>
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
		后台管理中心
		</div>
		<div class="sidebar">
			<dt>·服务器主机名称：<?php echo @$_SERVER['SERVER_NAME']; ?></dt>
			<dt>·服务器版本：<?php echo @$_ENV['OS'].@$_SERVER["OS"]?></dt>
			<dt>·通信协议名称/版本：<?php echo @$_SERVER['SERVER_PROTOCOL']; ?></dt>
			<dt>·服务器IP：<?php echo @$_SERVER["SERVER_ADDR"]; ?></dt>
			<dt>·客户端IP：<?php echo @$_SERVER["REMOTE_ADDR"]; ?></dt>
			<dt>·服务器端口：<?php echo @$_SERVER['SERVER_PORT']; ?></dt>
			<dt>·客户端端口：<?php echo @$_SERVER["REMOTE_PORT"]; ?></dt>
			<dt>·管理员邮箱：<?php echo @$_SERVER['SERVER_ADMIN'] ?></dt>
			<dt>·Host头部的内容：<?php echo @$_SERVER['HTTP_HOST']; ?></dt>
			<dt>·服务器主目录：<?php echo @$_SERVER["DOCUMENT_ROOT"]; ?></dt>
			<dt>·服务器系统盘：<?php echo @$_SERVER["SystemRoot"]; ?></dt>
			<dt>·脚本执行的绝对路径：<?php echo @$_SERVER['SCRIPT_FILENAME']; ?></dt>
			<dt>·Apache及PHP版本：<?php echo @$_SERVER["SERVER_SOFTWARE"]; ?></dt>
			
		</div>
	</div>
<?php
		require ROOT_PATH."/includes/manage.inc.php";
	?>
	
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>