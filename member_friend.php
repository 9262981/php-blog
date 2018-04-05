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
	define('SCRIPT','member_friend');
	//验证好友
	if(@$_GET['action']=='check'&&isset($_GET['id'])){
		if($_rows=_fetch_array("
		SELECT user_uniqid 
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		//修改state，通过验证
		_query("
				UPDATE pppf_friend 
				SET friend_state=1 
				WHERE friend_id='{$_GET['id']}'
		");
		if(_affected_rows()==1){
		   _close();
		   _location('好友验证成功！','member_friend.php');
		   }else{
		   _close();
		   _location('好友验证失败','member_friend.php');
		   } 
		
		}else{
			_alert_back('非法登陆DELFRIEND');
		}
	}
	//批量删除好友//implode — 将一个一维数组的值转化为字符串 
	if(@$_GET['action']=='delete'&&isset($_POST['ids'])){
		$_clean=array();
		$_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
		
		
		//危险操作，验证身份//删除好友部分
		if($_rows=_fetch_array("
		SELECT user_uniqid 
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		_query("
				DELETE 
				FROM pppf_friend
				WHERE friend_id 
				IN ({$_clean['ids']})
			   ");
		   if(_affected_rows()){
		   _close();
		   _location('删除成功！','member_friend.php');
		   }else{
		   _close();
		   _location('删除失败','member_friend.php');
		   } 
		}else{
			_alert_back('非法登陆');
		//删除短信 单条
		}
	}
	//分页模块
	global $_pagesize,$_pagenum;
	_page("SELECT	friend_id 
			FROM	pppf_friend
			WHERE	friend_touser='{$_COOKIE['username']}'"
			,15);
	//首先得到所有数
	//首先得到所有数据总和

	//从数据库提取数据获取结果集
	// $_result= mysql_query("SELECT user_username,user_sex,user_face FROM pppf_user");
	$_result= _query("
					SELECT	friend_id,friend_state,friend_fromuser,friend_touser,friend_content,friend_date 
					FROM	pppf_friend		
					
					WHERE	friend_fromuser='{$_COOKIE['username']}'
					OR		friend_touser='{$_COOKIE['username']}'
					ORDER BY friend_date DESC
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
<title><?=$_system['webname']?>-好友列表</title>
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
		好友管理中心
		</div>
		<form method="post" action="?action=delete">
		<table cellspacing="1">
		
		<tr><th>好友</th><th>请求内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
		<?php $_html=array();
			while(!!$_rows=_fetch_array_list($_result)){ 
			$_html['id']=$_rows['friend_id'];	
			$_html['touser']=$_rows['friend_touser'];
			$_html['fromuser']=$_rows['friend_fromuser'];
			$_html['content']=$_rows['friend_content'];
			$_html['state']=$_rows['friend_state'];
			$_html['date']=$_rows['friend_date'];
			$_html=_html($_html);
			if($_html['touser']==$_COOKIE['username']){
			   $_html['friend']=$_html['fromuser'];
			   if(empty($_html['state'])){
				   $_html['state_html']='<a href="?action=check&id='.$_html['id'].'"  style="color:red" >您未验证</a>';
			   }else{
				   $_html['state_html']='您已通过验证';
			   }
			}elseif($_html['fromuser']==$_COOKIE['username']){
			   $_html['friend']=$_html['touser'];
			  if(empty($_html['state'])){
				   $_html['state_html']='<span style="color:red">对方未验证</span>';
			   }else{
				   $_html['state_html']='对方已经验证';
			   }
			}
		?>
		<tr>
			<td><?php echo $_html['friend']?></td>
			<td title="<?php echo $_html['content'] ?>"><?php echo _title($_html['content'],10)?></td>
			<td><?php echo $_html['date'] ?></td>
			<td><?php echo $_html['state_html'] ?></td>
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