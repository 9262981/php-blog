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
	define('SCRIPT','photo');//css选择

	//分页模块
	global $_pagesize,$_pagenum;
	_page("SELECT user_id FROM pppf_user",$_system['blog']);
	//首先得到所有数据总和
	
	//从数据库提取数据获取结果集
	// $_result= mysql_query("SELECT user_username,user_sex,user_face FROM pppf_user");
	$_result= _query("
					SELECT user_id,user_username,user_sex,user_face 
					FROM pppf_user 
					ORDER BY user_reg_time DESC 
					LIMIT $_pagenum,$_pagesize
					");
	//mysql_query()  向与指定的 link_identifier 关联的服务器中的当前活动数据库发送一条查询（不支持多条查询）。 
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/blog.js"></script>
<title><?=$_system['webname']?>-相册列表</title>

<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>
<?php
	require ROOT_PATH."/includes/header.inc.php";
?>
	<div id="content" >
		<h2>相册列表</h2>
		<?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])){?>
		<div class="block" >
			<a href="photo_add_dir.php">添加相册</a>
		</div>
		<?php }?>
		<div class="block" >
		<?php 	$_html=array();
				while(!!$_rows=_fetch_array_list($_result)){ 
				$_html['id']=$_rows['user_id'];
				$_html['username']=$_rows['user_username'];
				$_html['face']=$_rows['user_face'];
				$_html['sex']=$_rows['user_sex'];
				$_html=_html($_html);
		?>
	<!--mysql_fetch_array — 从结果集中取得一行作为关联数组，或数字数组，或二者兼有  -->
			<div class="person">
				<img src="<?php echo $_html['face']?>">
				<dl class="nn"><a href="" class=""><?php echo $_html['username'].'['.$_html['sex'].']'?></a></dl>
				<dl class="xx"><a href="javascript:;" name="message" title="<?php echo $_html['id']?>" class="" >发消息</a></dl>
				<dl class="cc"><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>" class="">加好友</a></dl>
				<dl class="vv"><a href="" class="">写留言</a></dl>
				<dl class="bb"><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>" class="">送花</a></dl>
			</div>
		<? } 
		_free_result($_result);
		?>
			<div class="page">
				  <ul id="pagination-flickr">
					
				 <?php _paging(1);?>
				 <?php _paging(2);?>
				  
				  
				  
				
				</ul>
			</div>
		</div>	
	</div>
	
<?php
	require ROOT_PATH."includes/footer.inc.php";
?>

</body>
</html>