<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
 	session_start();//验证码生成session开始	
	header("Content-Type:text/html;charset=UTF-8");
	//title.inc 定义样式选择
	define('SCRIPT','member_message_detail');
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	
	if(!isset($_COOKIE['username'])){
	_location('请先登录1','login.php');
	}
	
	//删除短信模块
	if(@$_GET['action']=='delete'&&isset($_GET['id'])){
		//验证短信合法
		if(!!$_result= _fetch_array("
		SELECT	mess_id
		FROM	pppf_mess 
		WHERE	mess_id='{$_GET['id']}'
		LIMIT	1
		")){
		//危险操作，验证身份//删除短信部分
		if($_rows=_fetch_array("
		SELECT	user_uniqid 
		FROM	pppf_user 
		WHERE	user_username='{$_COOKIE['username']}' 
		LIMIT	1
		")){
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		echo'删除操作';
		//删除短信 单条
		_query("
		DELETE 
		FROM	pppf_mess
		WHERE	mess_id='{$_GET['id']}'
		LIMIT	1		
		"
		);
		
		
		if(_affected_rows()==1){
		   _close();
           _location('删除成功！','member_message.php');
		   }else{
		   _close();
		   _location('删除失败','member_message.php');
		   } 
		
		}
		}else{
			_alert_back('此条信息不存在');
		}
	}
	
	
 
	if(isset($_GET['id'])){
		$_result= _fetch_array("
		SELECT	mess_id,mess_state,mess_fromuser,mess_content,mess_date 
		FROM	pppf_mess 
		WHERE	mess_id='{$_GET['id']}'
		LIMIT	1
		");
		
		if($_result){
			//将state 设置为1；
			if(empty($_result['state'])){
				_query("
					UPDATE	pppf_mess 
					SET		mess_state=1
					WHERE	mess_id='{$_GET['id']}'
					LIMIT	1
				");
				
			}
			$_html=array();
			$_html['id']=$_result['mess_id'];
			$_html['fromuser']=$_result['mess_fromuser'];
			$_html['content']=$_result['mess_content'];
			$_html['date']=$_result['mess_date'];
		}
	}else{
		_alert_back('非法登陆:detail');
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<script type="text/javascript" src="assets/js/member_message_detail.js"></script>
<title>PPPFCMS-短信列表</title>
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
		<table cellspacing="1">
		
		<tr>
			<th>发件人</th><th><?php echo $_html['fromuser']?></th>
		</tr>
		
		<tr>
			<td>短信内容</td>
			<td><?php echo $_html['content']?></td>
		</tr>	
		<tr>
			<th>时间</th><th><?php echo $_html['date']?></th>
		</tr>
		<tr>
		<td></td>
		<td><input type="button"  value="返回列表" id="return"/>
		<input type="button" name="<?php echo $_html['id']?>" value="删除短信" id="delete"/></td>
		</tr>	
		
		
		</table>
		
	</div>
	<?php
		require ROOT_PATH."/includes/member.inc.php";
	?>
	
	<?php
		require ROOT_PATH."includes/footer.inc.php";
			
	?>

</body>
</html>