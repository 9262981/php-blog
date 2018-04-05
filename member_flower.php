<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
 	session_start();//验证码生成session开始	
	header("Content-Type:text/html;charset=UTF-8");
	
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	if(!isset($_COOKIE['username'])){
	_location('请先登录1','login.php');
	}
	//title.inc 定义样式选择
	define('SCRIPT','member_message');
	
	//批量删除花朵//implode — 将一个一维数组的值转化为字符串 
	if(@$_GET['action']=='delete'&&isset($_POST['ids'])){
		$_clean=array();
		$_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
		
		
		//危险操作，验证身份//删除短信部分
		if($_rows=_fetch_array("
		SELECT user_uniqid 
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		_query("
				DELETE 
				FROM pppf_flower
				WHERE flower_id 
				IN ({$_clean['ids']})
			   ");
		   if(_affected_rows()){
		   _close();
		   _location('删除成功！','member_flower.php');
		   }else{
		   _close();
		   _location('删除失败','member_flower.php');
		   } 
		}else{
			_alert_back('非法登陆');
		//删除短信 单条
		
		}
		
		
		
	}

	
		//分页模块
	global $_pagesize,$_pagenum;
	_page("SELECT flower_id FROM pppf_flower WHERE flower_touser='{$_COOKIE['username']}'",15);
	//首先得到所有数据总和

	//从数据库提取数据获取结果集
	// $_result= mysql_query("SELECT user_username,user_sex,user_face FROM pppf_user");
	$_result= _query("
					SELECT flower_id,flower_touser,flower_fromuser,flower_count,flower_content,flower_date 
					FROM pppf_flower 
					 
					WHERE flower_touser='{$_COOKIE['username']}'
					ORDER BY flower_date DESC
					LIMIT $_pagenum,$_pagesize
					");
	//mysql_query()  向与指定的 link_identifier 关联的服务器中的当前活动数据库发送一条查询（不支持多条查询）。 
	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/member_message.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-花朵管理中心</title>
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
		花朵管理中心
		</div>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
		
		<tr><th>送花人</th><th>留言内容</th><th>时间</th><th>送您</th><th>操作</th></tr>
		<?php 
			$_html=array();
			while(!!$_rows=_fetch_array_list($_result)){ 
			$_html['id']=$_rows['flower_id'];	
			$_html['fromuser']=$_rows['flower_fromuser'];
			$_html['content']=$_rows['flower_content'];
			$_html['date']=$_rows['flower_date'];
			$_html['count']=$_rows['flower_count'];
			$_html=_html($_html);
			@$_html['flowercount']+=$_html['count'];
			
		?>
		<tr>
			<td><?php echo $_html['fromuser']?></td>
			<td><?php echo $_html['content']?></td>
			<td><?php echo $_html['date']?></td>
			<td><?php echo $_html['count']?>朵花花</td>
			<td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>" /></td></tr>	
		<? } 
		_free_result($_result);
		?>
		<tr><th></th><th>共<?php echo $_html['flowercount']?>朵花</th><th>全选</th><th><input type="submit" value="批量删除"/></th><th><input  type="checkbox" name="chkall" id="all"/></th></tr>
		</table>
		</form>
		<div class="page">
				<ul id="pagination-flickr">
					
				 <?php _paging(1);?>
				 <?php _paging(2);?>
				  
				  
				  
				
				</ul>
		</div>
	</div>
	<?php
		require ROOT_PATH."/includes/member.inc.php";
	?>
	
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>