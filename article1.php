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
					$_html['subject_modify']='<a href="article_modify.php?id='.$_html['reid'].'">[修改]</a>';
					
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
				_alert_back('不存在此文章');
			}
		}else{
		_alert_back('非法操作');
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<script type="text/javascript" src="assets/js/article.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
<title><?=$_system['webname']?>-帖子详情</title>

<?php
	require ROOT_PATH."/includes/title.inc.php";
?>   
</head>
<body>
<?php
	require ROOT_PATH."/includes/header.inc.php";
?>
	<div id="article" >
		<h2>帖子详情</h2>
			
			<div class="block" >
				<div class="left">	
					<div class="photo">	
						<img src="<?php echo $_html['face'] ?>">
					</div>
					
						<dl class="nn"><a href="" class=""><?php echo $_html['username'] ?> (<?php echo $_html['sex'] ?>)</a></dl>
						<dl class="zz"><a href="mailto:<?php echo $_html['email'] ?>" title="" class="" >电子邮件：<?php echo $_html['email'] ?></a></dl>
						<dl class="zz"><a href="<?php echo $_html['url'] ?>" title="" target="_blank" class="" >主页：<?php echo $_html['url'] ?></a></dl>
						<dl class="xx"><a href="javascript:;" name="message" title="<?php echo $_html['userid'] ?>" class="" >发消息</a></dl>
						<dl class="cc"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'] ?>" class="">加好友</a></dl><br>
						<dl class="vv"><a href="" class="">写留言</a></dl>
						<dl class="bb"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'] ?>" class="">送花</a></dl>
						
				</div>
				<div class="right">
					<?php if($_page==1){?>
					<span>#1<?php echo @$_html['subject_modify']?><?php echo @$_html['re'] ?></span>
					<h3><?php echo $_html['username'] ?>[楼主]|发表于：<?php echo $_html['date'] ?></h3><hr><br>
					<h4>主题：<?php echo $_html['title'] ?><img src="assets/img/icon/icon<?php echo $_html['type']?>.gif" alt="icon" /></h4><br>
					
					<p><?php echo $_html['content']	 ?></p><br>
				
					&nbsp;&nbsp;阅读量：<?php echo $_html['readcount'] ?>&nbsp;&nbsp;回复数：<?php echo $_html['commendcount'] ?>
					<?php echo @$_html['last_modify_date_string'] ?>
					<br><?php } ?><?php echo $_html['html_autograph'] ?>
					
				</div>
				<div class="right">
					<?php  
						$_i=2;
						
						while(!!$_rows=_fetch_array_list($_result)){
						$_html['username']=$_rows['article_username'];
						$_html['type']=$_rows['article_type'];
						$_html['retitle']=$_rows['article_title'];
						$_html['content']=$_rows['article_content'];
						$_html['date']=$_rows['article_date'];
						$_html=_html($_html);
						
						if (!!$_rows = _fetch_array("SELECT 
																			user_id,
																			user_sex,
																			user_face,
																			user_email,
																			user_url,
																			user_switch,
																			user_autograph
															  FROM 
															  				pppf_user 
															WHERE 
																			user_username='{$_html['username']}'")) {
							//提取用户信息
							$_html['userid'] = $_rows['user_id'];
							$_html['sex'] = $_rows['user_sex'];
							$_html['face'] = $_rows['user_face'];
							$_html['email'] = $_rows['user_email'];
							$_html['url'] = $_rows['user_url'];
							$_html['switch'] = $_rows['user_switch'];
							$_html['html_reautograph'] = $_rows['user_autograph'];
							$_html = _html($_html);
							}
					//跟帖回复
					
					if(@$_COOKIE['username']){
						$_html['re']='<span><a href="#ree" name="re" title="回复'.($_i+(($_page-1)*$_pagesize)).'楼'.$_html['username'].'">【回复】</a></span>';
					}
					?>
					
					<h3><?php echo @$_html['re'] ?><?php echo $_html['username'] ?>|发表于：<?php echo $_html['date'] ?></h3>
					<h4>#<?php echo $_i+(($_page-1)*$_pagesize) ?>：<?php echo $_html['retitle'] ?><img src="assets/img/icon/icon<?php echo $_html['type']?>.gif" alt="icon" /></h4><br>
					<p><?php echo $_html['content'] ?></p><?php echo $_html['html_reautograph'] ?><hr><br>
					
					<?php 
						$_i++;
						}
						
					?>
					<div class="page">
						<ul id="pagination-flickr">
							<?php _free_result($_result); _paging(1);?>
							<?php _paging(2);?>
						</ul>
						</div>
					</div>
					
				<?php if(isset($_COOKIE['username'])){?>
				
				<div class="right">
				
						<form method="post"  action="?action=rearticle" >
						<dl>
						
						<dd class="img2">回复</dd>
						<dd>标题：<input type="text" name="title" value="RE:<?php echo $_html['title'] ?>" class="text" />*</dd>
						<input type="hidden" name="reid" value="<?php echo $_html['reid']?>">
						<input type="hidden" name="type" value="<?php echo $_html['type']?>">
					<a name="ree"></a>
						<dd id="q">贴　　图：<a href="javascript:;">Q图系列[1]　</a> <a href="javascript:;">Q图系列[2]　</a> <a href="javascript:;">Q图系列[3]  </a> </dd>
						
						<dd>内容：<br>
						
						<div id="font">
							<strong onclick="font(10)">10px</strong>
							<strong onclick="font(12)">12px</strong>
							<strong onclick="font(14)">14px</strong>
							<strong onclick="font(16)">16px</strong>
							<strong onclick="font(18)">18px</strong>
							<strong onclick="font(20)">20px</strong>
						</div>
						<textarea type="text" name="content" rows="9" placeholder="" /></textarea></dd>	
						<dd>验证码：<input type="text" name="code" class="text yzm"  />&nbsp;&nbsp;
							<img src="code.php" class="yzmimg" id="code" /></dd>
						<dd><input type="submit" value="发表帖子" class="submit" id="submit" /></dd>
						</dl>
						</form>
				
				</div>
				<?php }?>
			</div>
			
		</div>	
	</div>
	
<?php
	require ROOT_PATH."includes/footer.inc.php";
?>

</body>
</html>