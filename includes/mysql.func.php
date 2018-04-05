<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
header("Content-Type:text/html;charset=utf-8");
if (!defined('pppf')){
exit('非法调用');
}
//数据库连接
	define('DB_HOST','localhost');
	define('DB_USER','root');
	define('DB_PWD','root');
	define('DB_NAME','05blog');

//创建数据库连接
	function _connect(){
	global $_conn;//设置全局变量外部可以访问
	if(!$_conn = mysql_connect(DB_HOST,DB_USER,DB_PWD)){
		exit("数据库连接错误了，检查配置文件.错误信息1".mysql_error());
		}
	}

	//链接数据库
	function _select_db(){
		if(!mysql_select_db(DB_NAME)){
			exit("数据库连接错误了，检查配置文件.错误信息2".mysql_error());
		}
	}
	//选择字符集
	function _set_names(){
		if(!mysql_query('SET NAMES UTF8')){
			exit('字符集错误');
		}
	}
	//
	function _query($_sql){
		if(!$_result=mysql_query($_sql)){
			exit("sql执行失败".mysql_error());
		}
		return  $_result;
	}

	//表示影响到的记录数只能获取一条数据组
	function _fetch_array($_sql){
		return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
	}


	//为了防止死循环//mysql_fetch_array — 从结果集中取得一行作为关联数组，或数字数组，或二者兼有
	function _fetch_array_list($_result){
		return mysql_fetch_array($_result,MYSQL_ASSOC);
	}
	//取得结果集中行的数目 //mysql_num_rows
	function _num_rows($_result){
		return mysql_num_rows($_result);
	}
	//mysql_affected_rows — 取得前一次 MySQL 操作所影响的记录行数

function _affected_rows() {
	return mysql_affected_rows();
}
	function _is_repeat($_sql,$_info){
		if(_fetch_array($_sql)){
			_alert_back($_info);
		}
	}

	function _close(){
		if(!mysql_close()){
			exit('数据库关闭错误');
		}
	}
	function _insert_id(){
		return mysql_insert_id();
	}
	//初始化数据库
	_connect();   	//链接MYSQL数据库
	_select_db();	//选择指定的数据库
	_set_names();	//设置字符集
?>
