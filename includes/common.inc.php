<?php
/**
 * @version     2015-10-23 PPPFCMSv1.0.0
 * @author      apple森马
 * @copyright   Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
	header("Content-Type:text/html;charset=utf-8");
	if (!defined('pppf')){
	exit('非法调用');
	}
		global $_system;
/////////////////substr — 返回字符串的子串 //////////////////////////
	define("ROOT_PATH",substr(dirname(__FILE__),0,-8));

///创建一个自动转译状态的常量/get_magic_quotes_gpc — 获取当前 magic_quotes_gpc 的配置选项设置 //
	define('GPC',get_magic_quotes_gpc());
				
////拒绝php低版本
	if(PHP_VERSION<'4.4.0'){
	 
	 echo "您的PHP版本为".PHP_VERSION."<br>";
	 exit('拜托什么年代了，能升级下PHP版本不？');
	 
 }
 //执行时间
	require ROOT_PATH."includes/global.func.php";
	require ROOT_PATH."includes/mysql.func.php";
	/* 常量形式	*/
	define('START_TIME',_runtime());	/*超级全局变量 $GLOBALS['start_time']=_runtime(); */
 //短信提醒//COUNT(messid)是取得字段的总和
 @$_message=_fetch_array("
			SELECT COUNT(mess_id) 
			AS count 
			FROM pppf_mess 
			WHERE mess_state=0 AND mess_touser='{$_COOKIE['username']}'
			");
 if(empty($_message['count'])){
	 $GLOBALS['message']='<strong class="noread">(0)</strong>';
 }else{
	 $GLOBALS['message']='<strong class="read">('.$_message['count'].')</strong>';
 }
//网站系统设置初始化
if(!!$_rows=_fetch_array("
		SELECT	*
		FROM pppf_system 
		WHERE system_id=1
		LIMIT 1
		")){
			$_system=array();
			$_system['webname']=$_rows['system_webname'];
			$_system['article']=$_rows['system_article'];
			$_system['blog']=$_rows['system_blog'];
			$_system['photo']=$_rows['system_photo'];
			$_system['post']=$_rows['system_post'];
			$_system['re']=$_rows['system_re'];
			$_system['code']=$_rows['system_code'];
			$_system['skin']=$_rows['system_skin'];
			$_system['register']=$_rows['system_register'];
			$_system['string']=$_rows['system_string'];
			$_system=_html($_system);
		}else{
			exit('系统表异常，请联系管理');
		}
?>
