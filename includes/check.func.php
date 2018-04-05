<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */

	if (!defined('pppf')){
	exit('非法调用');
	}

	if(!function_exists('_alert_back')){
		exit('_alert_back()函数不存在请检查');
	}
	if(!function_exists('_mysql_string')){
		exit('_mysql_string()函数不存在请检查');
	}
	
	function _check_uniqid($_first_uniqid,$_end_uniqid){
		
		if((strlen($_first_uniqid))!=40||($_first_uniqid!=$_end_uniqid)){
			_alert_back('标识符异常');
		}
		
		return _mysql_string($_first_uniqid);
	}
	
/* 
*@_check_username检测过滤用户名
*@access(使用之权) public
*@param string $_string 受污染的用户名
*@param string $_string
*@param int $_min_num 最小位数
*@param int $_max_num 最大位数
*@return string 过滤后的用户名
 */
 
//username的长度敏感字符限制敏感用户名进行处理
	function _check_username($_string,$_min_num,$_max_num){
		 global $_system;
	//ID1 用户名去空格头尾// trim去除字符串首尾处的空白字符（或者其他字符） 
	$_string=trim($_string);
	
	//ID2 判断长度2-20
	if(mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
 		_alert_back('ID长度需要在'.$_min_num.'-'.$_max_num.'位之间');		
	}
	
	//限制敏感字符

	$_char_pattern = '/[<>\'\"\ ]/';
	if (preg_match($_char_pattern,$_string)) {
		_alert_back('用户名不得包含敏感字符');
	}
	//限制敏感用户名称
	$_mg=explode('|',$_system['string']);
	// $_mg[0]='江泽民';
	// $_mg[1]='胡锦涛';
	// $_mg[2]='李世民';
	//告诉用户，哪些不能注册

	 foreach ($_mg as $value) {
		@$_mg_string .= '[' . $value . ']' . '\n';
	}
	//绝对匹配//in_array — 检查数组中是否存在某个值 
	if(in_array($_string,$_mg)){
		_alert_back($_mg_string.'敏感用户名不能注册');
	}	
//mysql_escape_string//addslashes//mysql_real_escape_string//转译字符串
	
	return _mysql_string($_string);
}
//密码位数，以及两次密码的相同与否进行判断
/* 
*@_check_password验证密码
*@access(使用之权) public
*@param string $_first_pass
*@param string $_end_pass
*@param int $_min_num 最小位数
*@param int $_max_num 最大位数
*@return string $_first_pass 返回一个加密后的密码
 */
	function _check_password($_first_pass,$_end_pass,$_min_num,$_max_num){
	//判断密码
	if(strlen($_first_pass)<$_min_num){
		_alert_back('密码不得小于'.$_min_num.'位');
	}
	if(strlen($_first_pass)>$_max_num){
		_alert_back('密码不得大于'.$_max_num.'位');
	}
	if($_first_pass!==$_end_pass){
		_alert_back('两次输入的密码不一致');
	}
	return _mysql_string(sha1($_first_pass));
}
	function _check_modify_password($_string,$_min_num){
		if(empty($_string)){
		return null;}
		else{
			if(strlen($_string)<$_min_num){
						_alert_back('密码不得小于'.$_min_num.'位');
			}
			return sha1($_string); 
		}
	}
/* 
密码提示
*@_check_question返回密码提示
*@access(使用之权) public
*@param string $_string
*@param int $_min_num 最小位数
*@param int $_max_num 最大位数
*@return string $_string 返回密码提示
 */
	function _check_question($_string,$_min_num,$_max_num){
		 if(empty($_string)){
		return null;	
					} else 
					{
		if(mb_strlen($_string,'utf-8') < $_min_num || mb_strlen($_string,'utf-8') > $_max_num) {
 		_alert_back('密码提示'.$_min_num.'-'.$_max_num.'位之间');
		
	}
	}
	//返回密码提示
	return _mysql_string(($_string));
	}
/* 
密码回答
/* 

*@_check_question返回密码答案
*@access(使用之权) public
*@param string $_string
*@param int $_min_num 最小位数
*@param int $_max_num 最大位数
*@return string $_string 返回密码答案
 */

	function _check_answer($_ques,$_answ,$_min_num,$_max_num){
		$_answ=trim($_answ);
		if(empty($_ques)){
		return null;	
					} else 
					{
		if(mb_strlen($_answ,'utf-8') < $_min_num || mb_strlen($_answ,'utf-8') > $_max_num) {
		_alert_back('密码回答'.$_min_num.'-'.$_max_num.'位之间');
		
		}
		
	//密码提示回答不能一致
		if($_answ==$_ques){
			_alert_back('密码提示，密码回答不能一致');
		}
					}
	//返回密码提示
	return _mysql_string(sha1($_answ));
	}
	
	
	function _check_sex($_string){
		return $_string;
	}
	function _check_face($_string){
		return _mysql_string($_string);
	}
/**
 * _check_email() 检查邮箱是否合法
 * @access public
 * @param string $_string 提交的邮箱地址
 * @return string $_string 验证后的邮箱
 */
function _check_email($_string,$_min_num,$_max_num) {
	//参考bnbbs@163.com
	//[a-zA-Z0-9_] => \w
	//[\w\-\.] 16.3.
	//\.[\w+] .com.com.com.net.cn
	//正则挺起来比较麻烦，但是你理解了，就很简单了。
	//如果听起来比较麻烦，就直接套用

	   if(empty($_string)){
		return null;	
					} else {
		if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)) {
			_alert_back('邮件格式不正确！');
		}
		if(strlen($_string)<$_min_num||strlen($_string)>$_max_num){
		_alert_back('邮件长度不合法');
		}
	}
	
	return _mysql_string($_string);
}

/**
 * _check_qq() 检查qq格式
 * @access public
 * @param string $_string 提交的QQ
 * @return string $_string 验证后的QQ
 */
	function _check_qq($_string){
		if(empty($_string)){
			return null;
		}else{
			if(!preg_match('/^[1-9]{1}[\d]{4,9}$/',$_string)){
				_alert_back('qq格式不正确！');
			}
		}
		return _mysql_string($_string);
	}
	
/**
 * _check_url() 验证网址
 * @access public
 * @param string $_string 
 * @return string $_string 过滤后的网址
 */
	function _check_url($_string,$_max_num){
		if(empty($_string)||($_string=='http://')){
			return null;
		}else{
			if(!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)){
				_alert_back('网址不正确');
			}
			if(strlen($_string)>$_max_num){
				_alert_back('网址过长了');
			}
		}
		return _mysql_string($_string);
	}

function _check_content($_string){
	if(mb_strlen($_string,'utf-8')<3||mb_strlen($_string,'utf-8')>200){
		_alert_back('信息不得小于3位大于200位');
	}
	return $_string;
}


function _check_post_title($_string,$_min,$_max){
	if(mb_strlen($_string,'utf-8')<$_min||mb_strlen($_string,'utf-8')>$_max){
		_alert_back('标题不得小于2位大于40位');
	}
	return $_string;
}
function _check_post_content($_string,$_max){
	if(mb_strlen($_string,'utf-8')<$_max){
		_alert_back('帖子内容不得小于'.$_max.'位');
	}
	return $_string;
}
function _check_post_autograph($_string,$_max){
	if(mb_strlen($_string,'utf-8')>$_max){
		_alert_back('帖子内容不得大于'.$_max.'位');
	}
	return $_string;
}


?>