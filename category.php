<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
 	session_start();//验证码生成session开始	
	define ('pppf',true);
	/* 转换为硬路径，速度更快一些 */
	require dirname(__FILE__).'/includes/common.inc.php';
	//title.inc 定义样式选择
	define('SCRIPT','index');
	
	if(@$_GET['action']=='cate'&&isset($_GET['id'])){
		
	
	global $_pagesize,$_pagenum;
	_page("	SELECT	*	
			FROM pppf_article 
			WHERE article_reid=0 AND article_cid='{$_GET['id']}'",$_system['article']);
	$_result= _query("
					SELECT *
					FROM	pppf_article 
					WHERE	article_cid='{$_GET['id']}'
					ORDER BY article_date DESC 
					LIMIT $_pagenum,$_pagesize
					");

	}
					
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Startup Responsive Landing page Template for startup, web services, newsletter signup, lead generation etc..">
<title><?=$_GET['id']?>-分类页</title>
<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon" href="assets/img/apple_icons_57x57.png">
<link rel="apple-touch-icon" sizes="72x72" href="assets/img/apple_icons_72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="assets/img/apple_icons_114x114.png">
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

<script src="js/pace.js"></script>

<!-- Custom Google Font : Open Sans -->

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
      <h4><?=$_GET['id']?>-相关</h4>
     
    </div>
  </div>
</div>

<!-- // END SUBPAGE HEAD -->

<div class="container">
  <div class="row">
    <div class="col-md-9 has-margin-bottom alert alert-success"> 
      
      <!--Blog list-->
	<?php 
		$_htmllist=array();
		
		while(!!$_rows=_fetch_array_list($_result)){
			$_htmllist['id']=$_rows['article_id'];
			$_htmllist['type']=$_rows['article_type'];
			$_htmllist['readcount']=$_rows['article_readcount'];
			$_htmllist['commendcount']=$_rows['article_commendcount'];
			$_htmllist['date']=$_rows['article_date'];
			$_htmllist['username']=$_rows['article_username'];
			$_htmllist['title']=$_rows['article_title'];
			$_htmllist['cid']=$_rows['article_cid'];
			$_htmllist['uid']='article.php?id='.$_htmllist['id'];
		
	?>
     <div class="row has-margin-bottom">
        <!--<div class="col-md-4 col-sm-4"> <img class="img-responsive center-block" src="images/blog-thumb-1.jpg" alt="bulletin blog"> </div>-->
        <div class="col-md-12 col-sm-12 bulletin">
          
		  <h5 class="media-heading"><a href="<?=$_htmllist['uid'];?>"><?=$_htmllist['title']?></a></h5>
		  </div>
		</div>
		<div class="row has-margin-bottom">
        
        <div class="col-md-9 col-sm-9 bulletin">
			<p>浏览：<?=$_htmllist['readcount']?> 评论：<?=$_htmllist['commendcount']?></p>
			 <p><?=$_htmllist['date']?> by <?=$_htmllist['username']?></p>
		</div>
		<div class="col-md-2 col-sm-2 bulletin">
			<p ><a class="btn btn-primary " href="category.php?action=cate&id=<?=$_htmllist['cid'];?>" role="button">类别：<?=$_htmllist['cid']?></a> </p>
		</div>
		<div class="col-md-1 col-sm-1 bulletin">
			<p ><a class="btn btn-primary " href="<?=$_htmllist['uid'];?>" role="button">查看</a> </p>
		</div>
          
      </div>
	  <hr>
      
      <!--Blog list-->
		<?php 
		} 
		_free_result($_result);
		?>
    
      <div class="text-center center-block">
        <ul class="pagination">
		
			<?php _paging(1);?>
       
        </ul>
      </div>
	  
	  
    </div>
    <!--// col md 9--> 
    
    <!--Blog Sidebar-->
   <?php
	require ROOT_PATH."includes/blogslider.inc.php";
	?>
</div>
</div>

<?php
	require ROOT_PATH."includes/footer.inc.php";
?>
