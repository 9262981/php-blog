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
	
	//批量删除短信//implode — 将一个一维数组的值转化为字符串 
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
				FROM pppf_mess
				WHERE mess_id 
				IN ({$_clean['ids']})
			   ");
		   if(_affected_rows()){
		   _close();
		   _location('删除成功！','member_message.php');
		   }else{
		   _close();
		   _location('删除失败','member_message.php');
		   } 
		}else{
			_alert_back('非法登陆');
		//删除短信 单条
		
		}
		
		
		
	}
	//分页模块

	global $_pagesize,$_pagenum;
	_page("SELECT mess_id FROM pppf_mess WHERE mess_touser='{$_COOKIE['username']}'",15);
	//首先得到所有数据总和

	//从数据库提取数据获取结果集
	// $_result= mysql_query("SELECT user_username,user_sex,user_face FROM pppf_user");
	$_result= _query("
					SELECT mess_id,mess_state,mess_fromuser,mess_touser,mess_content,mess_date 
					FROM pppf_mess 
					 
					WHERE mess_fromuser='{$_COOKIE['username']}'
					ORDER BY mess_date DESC
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
<title><?=$_system['webname']?>-短信列表</title>
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
		短信管理中心
		</div>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
		
		<tr><th>发给</th><th>短信内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
		<?php 
			$_html=array();
			while(!!$_rows=_fetch_array_list($_result)){ 
			$_html['id']=$_rows['mess_id'];	
			$_html['touser']=$_rows['mess_touser'];
			$_html['date']=$_rows['mess_date'];
			$_html=_html($_html);
			if(empty($_rows['mess_state'])){
			$_html['state']='<img src="assets/img/meg.gif" alt="未读">';
			$_html['content']='<strong>'.$_rows['mess_content'].'</strong>';
			}
			else{
				$_html['state']='<img src="assets/img/read.gif" alt="已读">';
				$_html['content']=$_rows['mess_content'];
			}
		?>
		<tr>
			<td><?php echo $_html['touser']?></td>
			<td><a href="member_message_detail.php?id=<?php echo $_html['id']?>" title="<?php echo $_html['content']?>"><?php echo $_html['content']?></a></td>
			<td><?php echo $_html['date']?></td>
			<td><?php echo $_html['state']?></td>
			<td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>" /></td></tr>	
		<? } 
		_free_result($_result);
		?>
		<tr><th></th><th></th><th>全选</th><th><input type="submit" value="批量删除"/></th><th><input  type="checkbox" name="chkall" id="all"/></th></tr>
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