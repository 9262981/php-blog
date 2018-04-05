<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	session_start();
	define ('pppf',true);//外部调用定义	pppf
	require dirname(__FILE__).'/includes/common.inc.php';/* 转换为硬路径，速度更快一些 */
	define('SCRIPT','friend');//css选择
	if(!isset($_COOKIE['username'])){
		_location('请先登录3','login.php');
	}
	//添加好友
	if(@$_GET['action']=='add'){
		_check_code($_POST['code'],$_SESSION['code']);
		if(!!$_rows=_fetch_array("
			SELECT	user_uniqid
			FROM	pppf_user 
			WHERE	user_username='{$_COOKIE['username']}' 
			LIMIT	1
			")){
			
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);}
		include ROOT_PATH."/includes/check.func.php";
		$_clean=array();
		$_clean['touser']=$_POST['touser'];
		$_clean['fromuser']=$_COOKIE['username'];
		$_clean['content']=_check_content($_POST['content']);
		$_clean=_mysql_string($_clean);
		
	//不能添加自己
	if ($_clean['touser'] == $_clean['fromuser']) {
		_alert_close('请不要添加自己！');
	}
	
	//数据库验证是否添加
	if(!!$_rows=_fetch_array
	("
	SELECT	friend_id
	FROM	pppf_friend
	WHERE	(friend_touser='{$_clean['touser']}' 
			AND friend_fromuser='{$_clean['fromuser']}' )
			OR 
			(friend_fromuser='{$_clean['fromuser']}' 
			AND friend_touser='{$_clean['touser']}' )
			LIMIT 1
	")){
		_alert_close("你们已经是好友了！或者对方还没有验证，无需添加！");
	}else{
		//添加好友信息
		_query("
		INSERT 
		INTO	pppf_friend(
							friend_touser,
							friend_fromuser,
							friend_content,
							friend_date
							)
				VALUES		(
							'{$_clean['touser']}',
							'{$_clean['fromuser']}',
							'{$_clean['content']}',
							NOW()
							)
		");
		if(_affected_rows()==1){
			_close();
			//_session_destroy();
			_alert_close('添加成功,请等待验证');
			}else{
			_close();
			//_session_destroy();
			_alert('添加失败');} 
		
		exit();
	}
}
	//获取数据
	if(isset($_GET['id'])){
			if(!!$_rows=_fetch_array("
									SELECT	user_username 
									FROM	pppf_user 
									WHERE	user_id='{$_GET['id']}' 
									LIMIT	1
				")){
				$_html=array();
				$_html['touser']=$_rows['user_username'];
				$_html=_html($_html);
			}else{
					_alert_close('不存在此用户01！');
			}
		}else{
		_location('请先登录friend','login.php');
		}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/message.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-加为好友</title>

<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>

	<div id="friend" >
		<h4>加好友</h4>
		<div class="content" >
		<form method="post"  action="?action=add" >
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
			<dl>
				<input type="hidden" value="<?php echo $_html['touser']?>" name="touser">
				<dd><input type="text" readonly="readonly"  name="" class="text" value="发送给:<?php echo $_html['touser']?>"/></dd>
				<dd><textarea type="password" name="content" class="textarea" />您好，可以加个好友吗？</textarea></dd>
				
				<dd>验 证 码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                    <img src="code.php" class="yzmimg" id="code" /></dd>
				<dd><input type="submit" value="提交" class="submit"  /></dd>
			 </dl>
		</form>
			
		</div>	
	</div>


</body>
</html>