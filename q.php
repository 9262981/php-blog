<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	define ('pppf',true);
	require dirname(__FILE__).'/includes/common.inc.php';
	/* 转换为硬路径，速度更快一些 */
	define('SCRIPT','q');
	//初始化
	if(isset($_GET['num'])&&isset($_GET['path'])){
		if(!is_dir(ROOT_PATH.$_GET['path'])){
			_alert_back('非法操作q2');
		}
	}else{
		_alert_back('非法操作q');
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>Q图选择选择</title>
<?php
	require ROOT_PATH."/includes/title.inc.php";
?>
<script type="text/javascript" src="assets/js/q.js"></script>
</head>
	<body>
		<div id="face">
		<h1>选择Q图</h1><br>
			<dl>
				<?php foreach(range(1,$_GET['num']) as $_num) {?>
				<dt><img src="<?php echo $_GET['path'].$_num ?>.gif" alt="<?php echo $_GET['path'].$_num ?>.gif" title="q图<?php echo $_num?>"  /></dt>
				<?php }?>
			</dl>
			
		</div>
	</body>
</html>



