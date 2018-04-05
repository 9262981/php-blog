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
	//title.inc 定义样式选择
	define('SCRIPT','member_modify');
	_manage_login();
	//修改资料
	if(@$_GET['action']=='set'&&isset($_GET['id'])){
		if(!!$_rows=_fetch_array("
		SELECT *
		FROM pppf_user 
		WHERE user_id='{$_GET['id']}' 
		LIMIT 1
		")){
		//比对唯一标识符防止cookie伪造
		/* 
		if($_rows['user_uniqid']!=$_COOKIE['uniqid']){
			_alert_back('异常登录1623');
		} */
		
		include ROOT_PATH."/includes/check.func.php";	
		$_clean=array();
		$_clean['password']=_check_modify_password($_POST['password'],6);
		$_clean['sex']=_check_sex($_POST['sex']);
		$_clean['face']=_check_face($_POST['face']);
		$_clean['email']=_check_email($_POST['email'],6,30);
		$_clean['qq']=_check_qq($_POST['qq']);
		$_clean['url']=_check_url($_POST['url'],40);
		$_clean['switch']=$_POST['switch'];
		$_clean['autograph']=_check_post_autograph($_POST['autograph'],200);
		//修改资料
		if(empty($_clean['password'])){
			_query("UPDATE pppf_user SET 
										user_sex='{$_clean['sex']}',
										user_face='{$_clean['face']}',
										user_email='{$_clean['email']}',
										user_qq='{$_clean['qq']}',
										user_url='{$_clean['url']}',
										user_switch='{$_clean['switch']}',
										user_autograph='{$_clean['autograph']}'
									WHERE
										user_id='{$_GET['id']}'
										");
		}else{
			_query("UPDATE pppf_user SET 
										user_password='{$_clean['password']}',
										user_sex='{$_clean['sex']}',
										user_face='{$_clean['face']}',
										user_email='{$_clean['email']}',
										user_qq='{$_clean['qq']}',
										user_url='{$_clean['url']}',
										user_switch='{$_clean['switch']}',
										user_autograph='{$_clean['autograph']}'
									WHERE
										user_id='{$_GET['id']}'
										");
		}
	} 
	//判断是否修改成功

	if (_affected_rows() == 0) {
		_close();
		//_session_destroy();
		_location('很遗憾，没有任何数据被修改！','manage_member.php');
		
	} else {
		_close();
		//_session_destroy();
		_location('恭喜你，修改成功！','manage_member.php');
	}									
}

	//取得资料
	if(@$_GET['action']=='modify'&&isset($_GET['id'])){
	$_rows=_fetch_array("
	SELECT user_username,user_sex,user_face,user_email,user_url,user_qq,user_switch,user_autograph
	FROM pppf_user 
	WHERE user_id='{$_GET['id']}'
						");
	if($_rows){
			/* $_username=$_rows['user_username'];
			$_sex=$_rows['user_sex']; 太多变量不容易记，创建数组处理*/
			$_html=array();
			$_html['username']=$_rows['user_username'];
			$_html['sex']=$_rows['user_sex'];
			$_html['face']=$_rows['user_face'];
			$_html['email']=$_rows['user_email'];
			$_html['url']=$_rows['user_url'];
			$_html['qq']=$_rows['user_qq'];
			$_html['switch']=$_rows['user_switch'];
			$_html['autograph']=$_rows['user_autograph'];
			$_html=_html($_html);
		//性别选择
			if ($_html['sex'] == '男') {
				$_html['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked"   /> 男 <input type="radio" name="sex" value="女"  /> 女';
			} elseif ($_html['sex'] == '女') {
				$_html['sex_html'] = '<input type="radio" name="sex" value="男"  /> 男 <input type="radio" name="sex" value="女" checked="checked" /> 女';
			}
		////////////////
		//头像选择
		$_html['face_html'] = '<select name="face">';
		foreach (range(1,12) as $_num) {
			if ($_html['face'] == 'assets/img/face2/'.$_num.'.png') {
				$_html['face_html'] .= '<option value="assets/img/face2/'.$_num.'.png" selected="selected">assets/img/face2/'.$_num.'.png</option>';
			} else {
				$_html['face_html'] .= '<option value="assets/img/face2/'.$_num.'.png">assets/img/face2/'.$_num.'.png</option>';
			}
		}
		
		$_html['face_html'] .= '</select>';
		
		
		
		//签名开关
		if($_html['switch']==1){
			$_html['switch_html']='<input type="radio" value="1" name="switch" checked="checked">启用
										   <input type="radio" value="0" name="switch" > 禁用';
		}elseif($_html['switch']==0){
			$_html['switch_html']='<input type="radio" value="1" name="switch" >启用
										   <input type="radio" value="0" name="switch" checked="checked"> 禁用';
		}
		////////////////
		}else{
			_alert_back('此用户不存在');
		}

	}
			
			
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/member_modify.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-用户修改</title>
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
		会员管理中心
		</div>
		<div class="sidebar">
		<form  method="post" action="?action=set&id=<?=$_GET['id']?>">
		
			<dt><span>用户名: </span><p><?php echo $_html['username'];?> </p></dt>
			<dt><span>密码: </span><input type="password" class="text" name="password" />（留空不修改） </dt>
			<dt><span>性别: </span><?php echo $_html['sex_html'];?> </dt>
			
			<dt><span>头像: </span><?php echo $_html['face_html'];?> </dt>
			<dt><span>电子邮件: </span><input type="text" class="text" name="email" value="<?php echo $_html['email'];?>"></dt>
		
			<dt><span>主页: </span><input type="text" class="text" name="url" value="<?php echo $_html['url'];?>"> </dt>
			<dt><span>QQ:</span><input type="text" class="text" name="qq" value="<?php echo $_html['qq'];?>"> </dt>
			<dt><span>个性签名:</span><?php echo $_html['switch_html'];?></dt>
									  <dl> <textarea name="autograph" class="textarea"><?php echo $_html['autograph'];?></textarea></dl>
			<dt><span>验 证 码:</span><input type="text" name="code" class="text yzm"  /> <img src="code.php" class="yzmimg" id="code" />
			<input type="submit" value="修改资料" class="submit"  />
			</form>
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