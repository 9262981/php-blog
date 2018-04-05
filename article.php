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
	define('SCRIPT','article');//css选择
	//处理回帖
		

	if(@$_GET['action']=='rearticle'){
		_check_code($_POST['code'],$_SESSION['code']);
		if($_rows=_fetch_array("
		SELECT user_uniqid 
		FROM pppf_user 
		WHERE user_username='{$_COOKIE['username']}' 
		LIMIT 1
		")){
		_uniqid($_rows['user_uniqid'],$_COOKIE['uniqid']);
		_timed(time(),@$_COOKIE['re_time'],$_system['re']);
		//接收数据
		$_clean=array();
		$_clean['reid']=$_POST['reid'];
		$_clean['type']=$_POST['type'];
		$_clean['title']=$_POST['title'];
		$_clean['content']=$_POST['content'];
		$_clean['username']=$_COOKIE['username'];
		$_clean=_mysql_string($_clean);
		//写入数据库
		_query("INSERT INTO pppf_article 
					(
					article_reid,
					article_username,
					article_title,
					article_type,
					article_content,
					article_date
					)
					VALUES
					(
					'{$_clean['reid']}',
					'{$_clean['username']}',
					'{$_clean['title']}',
					'{$_clean['type']}',
					'{$_clean['content']}',
					NOW()
					)
			   ");
			   if(_affected_rows()==1){
					_query("
							UPDATE	pppf_article 
							SET		article_commendcount=article_commendcount+1
							WHERE	article_reid=0 
							AND 	article_id='{$_clean['reid']}'
					");
					setcookie('re_time',time());
					_close();
					//_session_destroy();
					_location('回帖成功！','article.php?id='.$_clean['reid']);
					}else{
					_alert_back('回帖不成功');
					} ;
		}else{
			_alert_back('非法登陆！');
		}
	}
	//读出数据
	if(isset($_GET['id'])){
		if(!!$_rows=_fetch_array
		("	SELECT	*
			FROM	pppf_article
			WHERE	article_reid=0 AND article_id='{$_GET['id']}'")){
				//累计阅读量
				_query("UPDATE pppf_article 
						SET article_readcount=article_readcount+1 
						WHERE article_id='{$_GET['id']}'");
				$_html=array();
				$_html['reid']=$_rows['article_id'];
				$_html['username']=$_rows['article_username'];
				$_html['type']=$_rows['article_type'];
				$_html['title']=$_rows['article_title'];
				$_html['content']=$_rows['article_content'];
				$_html['readcount']=$_rows['article_readcount'];
				$_html['commendcount']=$_rows['article_commendcount'];
				$_html['last_modify_date']=$_rows['article_last_modify_date'];
				$_html['date']=$_rows['article_date'];
				//创建一个全局变量，做一个待参的分页
				global $_id;
				$_id='id='.$_html['reid'].'&';
		//拿出用户信息
		if(!!$_rows=_fetch_array
		("	SELECT	*
			FROM	pppf_user
			WHERE	user_username='{$_html['username']}'
			")){
				$_html['username']=$_rows['user_username'];
				$_html['userid']=$_rows['user_id'];
				$_html['face']=$_rows['user_face'];
				$_html['email']=$_rows['user_email'];
				$_html['sex']=$_rows['user_sex'];	
				$_html['url']=$_rows['user_url'];	
				$_html['switch']=$_rows['user_switch'];
				$_html['autograph']=$_rows['user_autograph'];
				
				
				if($_html['switch']==1){
					$_html['html_autograph']=$_html['autograph'].'-'.$_html['username'];
				}elseif($_html['switch']==0){
					$_html['html_autograph']='';
				}
				//主题帖子修改
				if($_html['username']==@$_COOKIE['username']){
					$_html['subject_modify']='<a href="article_modify.php?id='.$_html['reid'].'">[修改]</a>|<a href="article_del.php?action=del&id='.$_html['reid'].'">[删除文章]</a>';
					
				}
				//读取最后修改信息
				if($_html['last_modify_date']!='0000-00-00 00:00:00'){
					$_html['last_modify_date_string']='<br>本帖已由【'.$_html['username'].'】于'.$_html['last_modify_date'].'修改';
				}
				//给楼主回复
			if (@$_COOKIE['username']) {
				$_html['re'] = '<span>[<a href="#ree" name="re" title="回复1楼的'.$_html['username'].'">回复</a>]</span>';
			}
				//读取回帖
				global $_pagesize,$_pagenum,$_page;
				_page("
						SELECT article_id 
						FROM pppf_article 
						WHERE article_reid='{$_html['reid']}'
					  ",10);
						$_result= _query
						("
						SELECT article_username,article_type,article_content,article_date,article_title
						FROM pppf_article 
						WHERE article_reid='{$_html['reid']}'
						ORDER BY article_date ASC 
						LIMIT $_pagenum,$_pagesize
						");
				
			}else{
				_alert_back('不存在此用户');
			}
										
			}else{
				_location('不存在此文章','index.php');
			}
		}else{
		_alert_back('非法操作');
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo $_html['title'] ?>">
<title><?php echo $_html['title'] ?></title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.css" rel="stylesheet">

<!-- Startup CSS -->
<link href="css/startup.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Favicons -->
<link rel="shortcut icon" href="images/favicon.png">
<script src="js/pace.js"></script>
<script type="text/javascript" src="assets/js/article.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
</head>
<body>
<div class="preloader"></div>

 <!-- Fixed navbar -->
	<?php
	require ROOT_PATH."/includes/header.inc.php";
	?>
<!--// Navbar Ends--> 

<!--SUBPAGE HEAD-->

<div class="subpage-head">
  <div class="container">
    <div class="section-title">
      <h2><?php echo $_html['title'] ?></h2>
      <h4><?php echo $_html['date'] ?> by <?php echo $_html['username'] ?> <?php echo @$_html['subject_modify']?></h4>
    </div>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">
    <div class="col-md-9 has-margin-bottom">
      <article class="blog-content">
       <?php echo $_html['content']	 ?>
      </article>
      
      
    </div>
    <!--// col md 9--> 
    
    <!--Blog Sidebar-->
    <?php
	require ROOT_PATH."/includes/blogslider.inc.php";
	?>
</div>

<!-- FOOTER -->
<?php
	require ROOT_PATH."/includes/footer.inc.php";
?>