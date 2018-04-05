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
	define('SCRIPT','post');//css选择
	_manage_login();
	if(!isset($_COOKIE['username'])){
		_location('发帖前， 请先登录','login.php');
	}
	//将帖子写入数据库
	if(@$_GET['action']=='addcate'){
		//为了防止恶意注册，跨站攻击,验证码判断
	_check_code($_POST['code'],$_SESSION['code']);
	//验证是否在规定的时间外发帖

	if(!!$_rows=_fetch_array("
		SELECT *
		FROM pppf_category 
		
		")){

		//接收帖子内容
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
	
		$_clean['catename']=$_POST['catename'];
		
	
		//写入数据库
		_query("INSERT INTO	pppf_category 
				(category_name)
				VALUES
				('{$_POST['catename']}')					
					
				");
				if(_affected_rows()==1){
							$_clean['id']=_insert_id();
							// setcookie('post_time',time());
							$_clean['time']=time();
							
							_close();
							//_session_destroy();
							_location('恭喜添加分类成功！','manage_addcate.php');
							}else{
							_close();
							//_session_destroy();
							_alert_back('添加分类不成功');
							} 
		}
	}
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
<script type="text/javascript" src="assets/js/post.js"></script>
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

      <h4>添加分类</h4>
    </div>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">

  <div class="row">
	
	<?php
	require ROOT_PATH."/includes/manage.inc.php";
	?>
	  
    <div class="col-md-9 well">
      <article >
			<form method="post" name="post" action="?action=addcate" >
			
			<dd class="img2">分类名称:<input type="text" name="catename" placeholder="分类名称" class="text" />
			</dd>
			
		
			
			
			
			<dd>验证码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                <img src="code.php" class="yzmimg" id="code" /></dd>
			<dd><input type="submit" value="添加分类" class="submit" id="submit" /></dd>
			
		</form>
		
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


