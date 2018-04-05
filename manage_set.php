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
	define('SCRIPT','manage_set');
	//必须是管理员才能登录
	_manage_login();
	//修改系统表
	if(@$_GET['action']=='set'){
		if(!!$_rows=_fetch_array("
		SELECT user_uniqid 
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
			_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
			$_clean=array();
			$_clean['webname']=$_POST['webname'];
			$_clean['article']=$_POST['article'];
			$_clean['blog']=$_POST['blog'];
			$_clean['photo']=$_POST['photo'];
			$_clean['string']=$_POST['string'];
			$_clean['post']=$_POST['post'];
			$_clean['re']=$_POST['re'];
			$_clean['code']=$_POST['code'];
			$_clean['skin']=$_POST['skin'];
			$_clean['register']=$_POST['register'];
		
			//写入数据库
			_query("
					UPDATE	pppf_system
					SET		system_webname='{$_clean['webname']}',
							system_article='{$_clean['article']}',
							system_blog='{$_clean['blog']}',
							system_photo='{$_clean['photo']}',
							system_string='{$_clean['string']}',
							system_post='{$_clean['post']}',
							system_re='{$_clean['re']}',
							system_code='{$_clean['code']}',
							system_skin='{$_clean['skin']}',
							system_register='{$_clean['register']}'
					WHERE	system_id=1
					LIMIT	1
			");
			
		if (_affected_rows() == 1) {
				_close();
				//_session_destroy();
				_location('恭喜你，修改成功！','manage_set.php');
					
			} else {
				_close();
				//_session_destroy();
				_location('很遗憾，没有任何数据被修改！','manage_set.php');
			}	
			
		}else{
			_alert_back('异常set');
		}
	}
	//读取系统表
	if(!!$_rows=_fetch_array("
		SELECT	*
		FROM pppf_system 
		WHERE system_id=1
		LIMIT 1
		")){
			$_html=array();
			$_html['webname']=$_rows['system_webname'];
			$_html['article']=$_rows['system_article'];
			$_html['blog']=$_rows['system_blog'];
			$_html['photo']=$_rows['system_photo'];
			$_html['skin']=$_rows['system_skin'];
			$_html['string']=$_rows['system_string'];
			$_html['post']=$_rows['system_post'];
			$_html['re']=$_rows['system_re'];
			$_html['code']=$_rows['system_code'];
			$_html['register']=$_rows['system_register'];
			$_html=_html($_html);
			if($_html['article']==10){
				$_html['article_html']='<select name="article">
											<option value="10" selected="selected">每页10篇</option>
											<option value="15">每页15篇</option>
										</select>';
			}elseif($_html['article']==15){
				$_html['article_html']='<select name="article">
											<option value="10" >每页10篇</option>
											<option value="15" selected="selected">每页15篇</option>
										</select>';
			}
			
			if($_html['blog']==10){
				$_html['blog_html']='<select name="blog">
											<option value="10" selected="selected">每页10人</option>
											<option value="20">每页20人</option>
										</select>';
			}elseif($_html['blog']==20){
				$_html['blog_html']='<select name="blog">
											<option value="10" >每页10人</option>
											<option value="20" selected="selected">每页20人</option>
										</select>';
			}
			
			if($_html['photo']==10){
				$_html['photo_html']='<select name="photo">
											<option value="10" selected="selected">每页10篇</option>
											<option value="15">每页15篇</option>
										</select>';
			}elseif($_html['photo']==15){
				$_html['photo_html']='<select name="photo">
											<option value="10" >每页10篇</option>
											<option value="15" selected="selected">每页15篇</option>
										</select>';
			}
			
			if($_html['skin']==1){
				$_html['skin_html']='<select name="skin">
											<option value="1" selected="selected">第一套</option>
											<option value="2">第二套</option>
										</select>';
			}elseif($_html['skin']==2){
				$_html['skin_html']='<select name="skin">
											<option value="1" >第一套</option>
											<option value="2" selected="selected">第二套</option>
										</select>';
			}
			
			
			if($_html['post']==30){
				$_html['post_html']='<input type="radio" name="post" value="30" checked="checked">30秒<input type="radio" name="post" value="60" >60秒<input type="radio" name="post" value="90">90秒';
			}elseif($_html['post']==60){
				$_html['post_html']='<input type="radio" name="post" value="30" >30秒<input type="radio" name="post" value="60" checked="checked">60秒<input type="radio" name="post" value="90">90秒';
			}elseif($_html['post']==90){
				$_html['post_html']='<input type="radio" name="post" value="30" >30秒<input type="radio" name="post" value="60" >60秒<input type="radio" name="post" value="90" checked="checked">90秒';
			}
			
			if($_html['re']==15){
				$_html['re_html']='<input type="radio" name="re" value="15" checked="checked">15秒<input type="radio" name="re" value="60">60秒<input type="radio" name="re" value="90">90秒';
			}elseif($_html['re']==60){
				$_html['re_html']='<input type="radio" name="re" value="15" >15秒<input type="radio" name="re" value="60" checked="checked">60秒<input type="radio" name="re" value="90">90秒';
			}elseif($_html['re']==90){
				$_html['re_html']='<input type="radio" name="re" value="15" >15秒<input type="radio" name="re" value="60" >60秒<input type="radio" name="re" value="90" checked="checked">90秒';
			}
			
			if($_html['code']==1){
				$_html['code_html']='<input type="radio" name="code" value="1" checked="checked">启用<input type="radio" name="code" value="0" >不启用';
			}else{
				$_html['code_html']='<input type="radio" name="code" value="1" >启用<input type="radio" name="code" value="0" checked="checked">不启用';
			}
			
			if($_html['register']==1){
				$_html['register_html']='<input type="radio" name="register" value="1" checked="checked">启用<input type="radio" name="register" value="0" >不启用';
			}else{
				$_html['register_html']='<input type="radio" name="register" value="1" >启用<input type="radio" name="register" value="0" checked="checked">不启用';
			}
			
		}else{
			_alert_back('系统表出错，请联系管理员检查');
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
			<form method="post" action="?action=set">
			<dt>网站名称：<input type="text" name="webname" value="<?=$_html['webname']?>"></dt>
			<dt>文章每页列表数：<?=$_html['article_html']?></dt>
			<dt>博客每页列表数：<?=$_html['blog_html']?></dt>
			<dt>相册每页列表数：<?=$_html['photo_html']?></dt>
			<dt>敏感字符：<input type="text" name="string" value="<?=$_html['string']?>"></dt>
			<dt>发帖时间限制：<?=$_html['post_html']?></dt>
			<dt>回帖时间限制：<?=$_html['re_html']?></dt>
			<dt>站点默认皮肤：<?=$_html['skin_html']?></dt>
			<dt>登陆验证码：<?=$_html['code_html']?></dt>
			<dt>是否启用开放注册：<?=$_html['register_html']?></dt>
			<p><input type="submit" value="修改" class="submit"></p>
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
