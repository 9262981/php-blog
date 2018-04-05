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

	_manage_login();
	
	
	//添加目录
	//验证是否危险登陆
	if(@$_GET['action']=='adddir'){
		if(!!$_rows=_fetch_array("
				SELECT user_uniqid 
				FROM pppf_user 
				WHERE user_username='{$_COOKIE['username']}' 
				LIMIT 1
				")){
			
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		//接收数据
		$_clean=array();
		$_clean['name']=@$_POST['name'];
		$_clean['type']=@$_POST['type'];
		$_clean['password']=sha1(@$_POST['password']);
		$_clean['content'] = $_POST['content'];
		$_clean['dir'] = time();
		$_clean = _mysql_string($_clean);
		//先检查主目录是否存在
		// mkdir('photo',0777);添加photo目录
		//is_dir('photo');判断指定文件名是否存在
			if(!is_dir('photo')){
				mkdir('photo',0777);
			}
		//在主目录里创建自定义的相册目录
			if(!is_dir('photo/'.$_clean['dir'])){
			mkdir('photo/'.$_clean['dir']);
			}
		//把但钱的目录信息写入数据库即可
			if(empty($_clean['type'])){
			
			
				_query("
						INSERT INTO pppf_dir 
						(
							dir_name,
							dir_type,
							dir_content,
							dir_dir,
							dir_date
						)
				 VALUES (
							'{$_clean['name']}',
							'{$_clean['type']}',
							'{$_clean['content']}',
							'photo/{$_clean['dir']}',
							NOW()
						)
				");
		} else {

			_query("INSERT INTO pppf_dir (
																dir_name,
																dir_type,
																dir_content,
																dir_dir,
																dir_date,
																dir_password
															)
											 VALUES (
																'{$_clean['name']}',
																'{$_clean['type']}',
																'{$_clean['content']}',
																'photo/{$_clean['dir']}',
																NOW(),
																'{$_clean['password']}'
											 				)
			");
		}
			
			//目录添加成功
			if (_affected_rows() == 0) {
					_close();
					
					_location('目录添加失败','photo_add_dir.php');
					
				} else {
					_close();
					//_session_destroy();
					_location('目录添加成功','photo.php');
				}	
		}else{
		_alert_back('非法登陆adddir');
	}
}	
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/photo_add_dir.js"></script>
<title><?=$_system['webname']?>-添加相册</title>

<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>
<?php
	require ROOT_PATH."/includes/header.inc.php";
?>
	<div id="content" >
		<h2>添加相册</h2>
		<?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])){?>
		<div class="block" >
			<a href="photo_add_dir.php">添加相册</a>
		</div>
		<?php }?>
		<div class="block" >
			<form method="post" action="?action=adddir">
				<dl>
					<dd>相册名称：<input type="text" name="name" class="text"></dd>
					<dd>相册类型：<input type="radio" name="type" value="0" checked="checked" /> 公开 <input type="radio" name="type" value="1" /> 私密</dd>
					<dd id="pass">相册密码：<input type="password" name="password" class="password"></dd>
					<dd>相册简介：<textarea name="content"></textarea ></dd>
					<dd><input type="submit" value="添加相册目录" class="submit"></dd>
					
				</dl>
			</form>
		</div>	
	</div>
	
<?php
	require ROOT_PATH."includes/footer.inc.php";
?>

</body>
</html>