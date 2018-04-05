<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	//title.inc 定义样式选择
	define('SCRIPT','active');
	//开始激活处理
if (!isset($_GET['active'])) {
	_alert_back('非法操作2');

}
if (isset($_GET['action']) && isset($_GET['active']) && $_GET['action'] == 'ok') {
	$_active = _mysql_string($_GET['active']);
	if (_fetch_array("
						SELECT user_active
						FROM pppf_user
						WHERE user_active='$_active'
						LIMIT 1
						")) {
		//将tg_active设置为空
		_query("
				UPDATE pppf_user 
				SET user_active=NULL 
				WHERE user_active='$_active' 
				LIMIT 1
				");
		if (_affected_rows() == 1) {
			_close();
			_location('账户激活成功','login.php');
		} else {
			_close();
			_location('账户激活失败','register.php');
		}
	} else {
		_alert_back('非法操作1');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title><?=$_system['webname']?>-激活页面</title>
<?php
		require ROOT_PATH."/includes/title.inc.php";
	?>

	   
</head>
<body>
	<?php
		require ROOT_PATH."/includes/header.inc.php";
	?>

	<div id="reg" >
		<h2>会员注册</h2>
		<form method="post" name="register" action="register.php?action=register" >
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
		<dl>
			<dt>模拟邮件激活，点击链接激活账户！</dt>
				<dd><a href="active.php?action=ok&active=<?php echo $_GET['active'] ?>">激活</a></dd>
				
		</dl>
		
	</div>
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>