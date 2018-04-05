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
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $_html['title'] ?>">
<title><?=$_system['webname']?>-后台管理中心</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">

<!-- Startup CSS -->
<link href="css/startup.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Favicons -->
<link rel="shortcut icon" href="images/favicon.png">
<script src="js/pace.js"></script>
<script type="text/javascript" src="assets/js/article.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
</head>
<body>
<div class="preloader"></div>

 <!-- Fixed navbar -->
	<?php
	require ROOT_PATH."/includes/header.inc.php";
	?>
<!--// Navbar Ends--> 

<!--SUBPAGE HEAD-->

<div class="subpage-head">
  <div class="container">
    <div class="section-title">

      <h4>后台管理</h4>
    </div>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">

  <div class="row">
	
	<?php
	require ROOT_PATH."/includes/manage.inc.php";
	?>
	  
    <div class="col-md-9 ">
      <article class="blog-content">
			<li>·服务器主机名称：<?php echo @$_SERVER['SERVER_NAME']; ?></li>
			<li>·服务器版本：<?php echo @$_ENV['OS'].@$_SERVER["OS"]?></li>
			<li>·通信协议名称/版本：<?php echo @$_SERVER['SERVER_PROTOCOL']; ?></li>
			<li>·服务器IP：<?php echo @$_SERVER["SERVER_ADDR"]; ?></li>
			<li>·客户端IP：<?php echo @$_SERVER["REMOTE_ADDR"]; ?></li>
			<li>·服务器端口：<?php echo @$_SERVER['SERVER_PORT']; ?></li>
			<li>·客户端端口：<?php echo @$_SERVER["REMOTE_PORT"]; ?></li>
			<li>·管理员邮箱：<?php echo @$_SERVER['SERVER_ADMIN'] ?></li>
			<li>·Host头部的内容：<?php echo @$_SERVER['HTTP_HOST']; ?></li>
			<li>·服务器主目录：<?php echo @$_SERVER["DOCUMENT_ROOT"]; ?></li>
			<li>·服务器系统盘：<?php echo @$_SERVER["SystemRoot"]; ?></li>
			<li>·脚本执行的绝对路径：<?php echo @$_SERVER['SCRIPT_FILENAME']; ?></li>
			<li>·Apache及PHP版本：<?php echo @$_SERVER["SERVER_SOFTWARE"]; ?></li>
      </article>
      
      
    </div>
    <!--// col md 9--> 
    
    <!--Blog Sidebar-->
	</div>
</div>
<!-- FOOTER -->
<?php
	require ROOT_PATH."/includes/footer.inc.php";
?>
