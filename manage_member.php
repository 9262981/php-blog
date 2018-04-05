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
	//必须是管理员才能登录
	_manage_login();
	//title.inc 定义样式选择
	define('SCRIPT','member_message');
		if(@$_GET['action']=='del'&&isset($_GET['id'])){
			if($_rows=_fetch_array("
				SELECT * 
				FROM pppf_user 
				WHERE user_id='{$_GET['id']}' 
				LIMIT 1
				")){
				
				_query("
						DELETE 
						FROM pppf_user
						WHERE user_id='{$_GET['id']}'
						
					   ");
				   if(_affected_rows()){
				   _close();
				   _location('删除成功！','manage_member.php');
				   }else{
				   _close();
				   _location('删除失败','manage_member.php');
				   } 
				}
	}
	//分页模块
	global $_pagesize,$_pagenum;
	_page("SELECT user_id FROM pppf_user",10);
	$_result= _query("
					SELECT user_id,user_username,user_email,user_reg_time
					FROM pppf_user 
					ORDER BY user_reg_time DESC 
					LIMIT $_pagenum,$_pagesize
					");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/member_message.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-会员列表</title>
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
		会员列表中心
		</div>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
		
		<tr><th>会员ID号</th><th>会员名</th><th>邮件</th><th>注册时间</th><th>操作</th></tr>
		<?php 	$_html=array();
				while(!!$_rows=_fetch_array_list($_result)){ 
				$_html['id']=$_rows['user_id'];
				$_html['username']=$_rows['user_username'];
				$_html['email']=$_rows['user_email'];
				$_html['reg_time']=$_rows['user_reg_time'];
				$_html=_html($_html);
		?>
		<tr>
			<td><?=$_html['id']?></td>
			<td><?=$_html['username']?></td>
			<td><?=$_html['email']?></td>
			<td><?=$_html['reg_time']?></td>
		
			<td><a href="?action=del&id=<?=$_html['id']?>">删除</a>|<a href="manage_member_modify.php?action=modify&id=<?=$_html['id']?>">修改</td>
		</tr>	
				<?php }_free_result($_result); ?>
	
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
		require ROOT_PATH."/includes/manage.inc.php";
	?>
	
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>