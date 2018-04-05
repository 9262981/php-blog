<?php

 	session_start();//验证码生成session开始	
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	//title.inc 定义样式选择
	define('SCRIPT','index');
	global $_pagesize,$_pagenum;
	_page("SELECT article_id FROM pppf_article WHERE article_reid=0",$_system['article']);
	$_result= _query("
					SELECT article_id,article_title,article_type,article_readcount,article_commendcount 
					FROM pppf_article 
					WHERE article_reid=0
					ORDER BY article_date DESC 
					LIMIT $_pagenum,$_pagesize
					");
	
				$_htmllist=array();

				while(!!$_rows=_fetch_array_list($_result)){
					$_htmllist['id']=$_rows['article_id'];
					$_htmllist['type']=$_rows['article_type'];
					$_htmllist['readcount']=$_rows['article_readcount'];
					$_htmllist['commendcount']=$_rows['article_commendcount'];
					$_htmllist['title']=$_rows['article_title'];
					
				} 

	echo (json_encode($_htmllist));

	// $_arr = array('a'=>1, 'b'=>2, 'c'=>3);
	// $_result = json_encode($_arr);
	// echo $_result;

?>
