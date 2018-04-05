<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
header("Content-Type:text/html;charset=utf-8");

//创建数据库连接
	if(@$_GET['action']=='demo'){
		mysql_connect ( "localhost" ,  "root" ,  "root" );

		mysql_select_db ( "ue" );
		mysql_query ("INSERT INTO pppf 
					(
					
					content
					)
				VALUES
					(
					'{$_POST['content']}'
				
						
					) 
				");
	
	}
	mysql_connect ( "localhost" ,  "root" ,  "root" );

		mysql_select_db ( "ue" );
		$result  =  mysql_query ("SELECT * FROM pppf");
		while ( $row  =  mysql_fetch_array ( $result)) {
         echo $row[1];
    }


?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>ueditor demo</title>
</head>

<body>
	<div></div>
	<form method="post" action="demo.php?action=demo"> 
    <!-- 加载编辑器的容器 -->
    <script id="container" name="content" type="text/plain">
        这里写你的初始化内容
    </script>
    <!-- 配置文件 -->
    <script type="text/javascript" src="ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
	<input type="submit" >
	</form>
</body>

</html>