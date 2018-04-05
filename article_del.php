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
	define('SCRIPT','article_modify');//css选择
	if(!isset($_COOKIE['username'])){
		_location(' 请先登录','login.php');
	}
	//修改数据
		if(@$_GET['action']=='del'&&isset($_GET['id'])){
			_manage_login();
			
			if($_rows=_fetch_array("
				SELECT user_uniqid 
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
				//开始修改
					
				//执行sql
					_query("
						DELETE
						FROM	pppf_article
						WHERE	article_id='{$_GET['id']}'
					");
					if(_affected_rows()==1){
							
							_close();
							//_session_destroy();
							_location('删除成功！','index.php');
							}else{
							_close();
							//_session_destroy();
							_alert_back('删除不成功');
							} 
				}else{
					_alert_back('非法登陆');
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

<title><?=$_system['webname']?>-删除帖子帖子</title>

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
      <article class="blog-content">
			<form method="post" name="post" action="?action=modify" >
			<input type="hidden" value="<?php echo $_html['id']   ?>" name="id">
			<dl>
			<dt>请认真修改以下内容</dt>
			<dd class="img2">类型：
			<?php 
				foreach ((range(1,16)) as $_num){
					if($_num==$_html['type']){
					echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" checked="checked"/>';
					}else{
					echo '<label for="type'.$_num.'"><input type="radio" id="type'.$_num.'" name="type" value="'.$_num.'" />';}
					echo '<img src="assets/img/icon/icon'.$_num.'.gif" class="img2"></label>';
				}
			?></dd>
			<dd >标题：<input type="text" name="title" value="<?php echo $_html['title'] ?>" class="text" />*</dd>
			<dd id="q">分类：
				<select name="cid" > 
					<?php 
						$_resultt=_query("
									SELECT	* 
									FROM	pppf_category
									
							
									");
						$_htmll=array();
						while(!!$_rowss=_fetch_array_list($_resultt)){ 
						$_htmll['cid']=$_rowss['category_id'];
						$_htmll['name']=$_rowss['category_name'];
						
						$_htmll=_html($_htmll);
					?>
					<option value="<?=$_htmll['name']?>"><?=$_htmll['name']?></option> 
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
				<?=$_html['content']; ?>
			</script>
			</dd>
			<dd>验证码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                <img src="code.php" class="yzmimg" id="code" /></dd>
			<dd><input type="submit" value="修改帖子" class="submit" id="submit" /></dd>
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

