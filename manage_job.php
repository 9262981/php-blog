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
	//辞职
	if(@$_GET['action']=='job'&&isset($_GET['id'])){
		if (!!$_rows = _fetch_array("
			SELECT	user_uniqid
			FROM	pppf_user 
			WHERE	user_username='{$_COOKIE['username']}' 
			LIMIT	1
			")) {
			_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
			_query("
					UPDATE	pppf_user
					SET		user_level=0
					WHERE	user_username='{$_COOKIE['username']}' AND user_id='{$_GET['id']}';
				");
			if(_affected_rows()){
				   _close();
				   _location('辞职成功！','manage_job.php');
				   }else{
				   _close();
				   _location('辞职失败','manage_job.php');
				   } 
			}else{
				_alert_back('非法登陆job');
			}
	}
	if(@$_GET['action']=='add'){
		if (!!$_rows = _fetch_array("
			SELECT	user_uniqid
			FROM	pppf_user 
			WHERE	user_username='{$_COOKIE['username']}' 
			LIMIT	1
			")) {
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		$_clean=array();
		$_clean['username']=$_POST['manage'];
		$_clean=_mysql_string($_clean);
		//添加管理员
		_query("
				UPDATE	pppf_user
				SET		user_level=1
				WHERE	user_username='{$_clean['username']}'
				");
		if(_affected_rows()==1){
			$_clean['id']=_insert_id();
		   _close();
		   _location('管理员添加成功','manage_job.php');
		   }else{
			_close();
			   //_session_destroy();
			_alert_back('管理员添加成功失败','manage_job.php');} 
	}
	}
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
	_page("SELECT user_id FROM pppf_user WHERE user_level=1",10);
	$_result= _query("
					SELECT user_id,user_username,user_email,user_reg_time
					FROM pppf_user 
					WHERE user_level=1
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
<title><?=$_system['webname']?>-管理员管理列表</title>
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
		管理员管理列表
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
				if($_COOKIE['username']==$_html['username']){
					$_html['job_html']='<a href="manage_job.php?action=job&id='.$_html['id'].'">辞职</a>';
				}else{
					$_html['job_html']='无权操作';
				}
		?>
		<tr>
			<td><?=$_html['id']?></td>
			<td><?=$_html['username']?></td>
			<td><?=$_html['email']?></td>
			<td><?=$_html['reg_time']?></td>
		
			<td><?=$_html['job_html']?></td>
		</tr>	
		</form>		<?php }_free_result($_result); ?>
			<form method="post" action="?action=add">
				<tr>
					<td>添加管理</td>
					<td>（请输入管理员名称：）</td>
					<td><input type="text" name="manage"  class="text"></td>
					<td><input type="submit" value="添加管理员"></td>
				</tr>
			</form>
		</table>
		
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