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
	if(@$_GET['action']=='post'){
		//为了防止恶意注册，跨站攻击,验证码判断
	_check_code($_POST['code'],$_SESSION['code']);
	//验证是否在规定的时间外发帖

	if(!!$_rows=_fetch_array("
		SELECT user_uniqid,user_post_time
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
		//比对唯一标识符防止cookie伪造
		/* 
		if($_rows['user_uniqid']!=$_COOKIE['uniqid']){
			_alert_back('异常登录1623');
		} */
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		_timed(time(),$_rows['user_post_time'],$_system['post']);
		//接收帖子内容
		include ROOT_PATH.'includes/check.func.php';
		$_clean=array();
		$_clean['username']=$_COOKIE['username'];
		$_clean['type']=$_POST['type'];
		$_clean['cid']=$_POST['cid'];
		$_clean['title']=_check_post_title($_POST['title'],2,40);
		$_clean['content']=_check_post_content($_POST['content'],10);
	
		//写入数据库
		_query("INSERT INTO pppf_article 
					(
					article_username,
					article_title,
					article_type,
					article_cid,
					article_content,
					article_date
					)
				VALUES
					(
					'{$_clean['username']}',
					'{$_clean['title']}',
					'{$_clean['type']}',
					'{$_clean['cid']}',
					'{$_clean['content']}',
					NOW()		
					) 
				");
				if(_affected_rows()==1){
							$_clean['id']=_insert_id();
							// setcookie('post_time',time());
							$_clean['time']=time();
							_query("
							UPDATE	pppf_user 
							SET		user_post_time='{$_clean['time']}'
							WHERE	user_username='{$_COOKIE['username']}'
							");
							_close();
							//_session_destroy();
							_location('恭喜文章发布成功！','article.php?id='.$_clean['id']);
							}else{
							_close();
							//_session_destroy();
							_alert_back('发布不成功');
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
	  
    <div class="col-md-9 well">
      <article >
			<form method="post" name="post" action="?action=post" >
			<dl>
			<dt>请认真填写以下内容</dt>
			<dd class="img2">类型：
			<?php 
				foreach ((range(1,16)) as $_num){
					if($_num==1){
					echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" checked="checked"/>';
					}else{
					echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" />';}
					echo '<img src="assets/img/icon/icon'.$_num.'.gif" class="img2"></label>';
				}
			?></dd>
			<dd>标题：<input type="text" name="title" placeholder="标题2-40位" class="text" />*</dd>
			
			<dd id="q">分类：
				<select name="cid" > 
					<?php 
						$_result=_query("
									SELECT	* 
									FROM	pppf_category
									
							
									");
						$_html=array();
						while(!!$_rows=_fetch_array_list($_result)){ 
						$_html['cid']=$_rows['category_id'];
						$_html['name']=$_rows['category_name'];
						
						$_html=_html($_html);
					?>
					<option value="<?=$_html['name']?>"><?=$_html['name']?></option> 
					<? } 
					_free_result($_result);
					?>
				</select>
			</dd>
			
			<dd>内容：
			<!-- 编辑器开始 配置文件 -->
			<script type="text/javascript" src="includes/ue/ueditor.config.js"></script>
			<!-- 编辑器源码文件 -->
			<script type="text/javascript" src="includes/ue/ueditor.all.js"></script>
			<!-- 实例化编辑器 -->
			<script type="text/javascript">
				var ue = UE.getEditor('container');
			</script>
			<!-- 编辑器结束 -->
			
			<script id="container" name="content" type="text/plain">
				这里写你的初始化内容
			</script>
			</dd>
			<dd>验证码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                <img src="code.php" class="yzmimg" id="code" /></dd>
			<dd><input type="submit" value="发表帖子" class="submit" id="submit" /></dd>
			</dl>
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


