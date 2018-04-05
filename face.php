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
	define('SCRIPT','face');
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>头像选择</title>
<?php
	require ROOT_PATH."/includes/title.inc.php";
?>
<script type="text/javascript" src="assets/js/opener.js"></script>
</head>
	<body>
		<div id="face">
		<h1>选择头像</h1><br>
			<dl>
				<?php foreach(range(1,12) as $num) {?>
				<dt><img src="assets/img/face2/<?php echo $num ?>.png" alt="assets/img/face2/<?php echo $num ?>.png" title="头像<?php echo $num?>"  /></dt>
				<?php }?>
			</dl>
			
		</div>
	</body>
</html>



