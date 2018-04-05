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
	define('SCRIPT','flower');//css选择
	if(!isset($_COOKIE['username'])){
		_location('请先登录1','login.php');
	}
	//
	if(@$_GET['action']=='send'){
		_check_code($_POST['code'],$_SESSION['code']);
		///判断唯一标识符
		if(!!$_rows=_fetch_array("
				SELECT user_uniqid 
				FROM pppf_user 
				WHERE user_username='{$_COOKIE['username']}' 
				LIMIT 1
				")){
			
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		///判断唯一标识符
		include ROOT_PATH."/includes/check.func.php";
		$_clean=array();
		$_clean['touser']=$_POST['touser'];
		$_clean['fromuser']=$_COOKIE['username'];
		$_clean['count']=$_POST['count'];
		$_clean['content']=_check_content($_POST['content']);
		$_clean=_mysql_string($_clean);
		_query("
		INSERT INTO	pppf_flower
					(	flower_touser,
						flower_fromuser,
						flower_content,
						flower_count,
						flower_date	) 
					VALUES		
					(	'{$_clean['touser']}',
						'{$_clean['fromuser']}',
						'{$_clean['content']}',
						'{$_clean['count']}',
						NOW()	)
				");
		if(_affected_rows()==1){
			_close();
			//_session_destroy();
			_alert_close('送花成功');
			}else{
			_close();
			//_session_destroy();
			_alert('送花失败');} 
		
		}else{
		_alert_back('非法2');
		}
	
	}
	//获取数据
	if(isset($_GET['id'])){
			if(!!$_rows=_fetch_array("
									SELECT	user_username 
									FROM	pppf_user 
									WHERE	user_id='{$_GET['id']}' 
									LIMIT 	1
									")){
				$_html=array();
				$_html['touser']=$_rows['user_username'];
				$_html=_html($_html);
			}else{
					_alert_close('不存在此用户！');
			}
		}else{
		_location('请先登录2','login.php');
		}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/message.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-送花</title>

<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>

	<div id="message" >
		<h4>送花</h4>
		<div class="content" >
		<form method="post"  action="?action=send" >
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
			<dl>
				<input type="hidden" value="<?php echo $_html['touser']?>" name="touser">
				<dd><input type="text" readonly="readonly"  name="" class="text" value="发送给:<?php echo $_html['touser']?>"/></dd>
				<dd>
				<select name="count">
				<?php foreach(range(1,10) as $_num){
					echo '<option value="'.$_num.'">'.$_num.'朵花花</option>';
				}?>
					
				</select>
				</dd>
				<dd><textarea type="password" name="content" class="textarea" />非常欣赏你哦！送你小花一朵！</textarea>
				</dd>
				
				<dd>验 证 码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
                    <img src="code.php" class="yzmimg" id="code" /></dd>
				<dd><input type="submit" value="送花" class="submit"  /></dd>
			 </dl>
		</form>
			
		</div>	
	</div>


</body>
</html>