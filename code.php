<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
 
//创建session码//
 session_start();
//执行code函数
	define ('pppf',true);
	require dirname(__FILE__).'/includes/common.inc.php';
	/* 转换为硬路径，速度更快一些 */
	_code(120,25,4);
	
?>