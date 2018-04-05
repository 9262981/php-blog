<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */	
	session_start();//验证码生成session开始	
	define ('pppf',true);//外部调用定义	pppf
	require dirname(__FILE__).'/includes/common.inc.php';
	_login_state(); 
/* 	转换为硬路径，速度更快一些 */
	define('SCRIPT','login');//css选择
	//开始处理登陆状态
	if(@$_GET['action']=='login'){
		//为了防止恶意注册，跨站攻击,验证码判断
		if(!$_system['code']==0){
	_check_code($_POST['code'],$_SESSION['code']);
		}
	//引入验证文件（在表达式里面最好用include*是在需要的时候引入*函数或者表达式里面都可以包含*）
	include ROOT_PATH."/includes/login.func.php";	
	//接收数据
	$_clean=array();
	$_clean['username']=_check_username($_POST['username'],2,20);
	$_clean['password']=_check_password($_POST['password'],6);
	$_clean['time']=_check_time($_POST['time']);

	//到数据库验证
	if(!!$_rows=_fetch_array("
		SELECT	user_username,user_uniqid,user_level
		FROM	pppf_user 
		WHERE	user_username='{$_clean['username']}' AND user_password='{$_clean['password']}' AND user_active='' 
		LIMIT	1
		"))
							{
		//登陆成功后记录登陆信息
		_query("
				UPDATE pppf_user 
				SET user_last_time=NOW(),
					user_last_ip='{$_SERVER["REMOTE_ADDR"]}',
					user_login_count=user_login_count+1
				WHERE user_username='{$_rows["user_username"]}'
				");
		
		////_session_destroy();
		_setcookies($_rows['user_username'],$_rows['user_uniqid'],$_clean['time']);
		if($_rows['user_level']==1){
			$_SESSION['admin']=$_rows['user_username'];
		}
		_close();
		_location(null,'index.php');
	}else{
		_close();
		////_session_destroy();
		_location('用户名密码不正确或者账户未被激活','login.php');

	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Startup Responsive Landing page Template for startup, web services, newsletter signup, lead generation etc..">
<title><?=$_system['webname']?>-登陆</title>

<script type="text/javascript" src="assets/js/login.js"></script>
<script type="text/javascript" src="assets/js/code.js"></script>
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

<!-- Custom Google Font : Open Sans -->


</head>


<body class="signup-v-layout">
<div class="preloader"></div>
<!-- Parallax Header Starts -->
<main id="top" class="masthead" role="main">
  <div class="container"> 
    <!-- Startup Logo -->
    <div class="logo"> <a href="#"><img src="images/startup-template-logo.png" alt="startup-logo"></a> </div>
    <!-- Hero Title -->
    <h1><span data-typer-targets="WELCOME TO CONTROL PANNEL"></span> <br>
      to <strong data-typer-targets="launch your account"</strong> </h1>
    <!-- Mailchimp Subscribe form -->
    <div class="row">
	
                   
				
	

      <div class="col-md-4 col-sm-12 col-md-offset-4">
        <div class="signup-block"><form class="form" role="form"  method="post" name="login" action="login.php?action=login" >
          <div class="form-group">
            <input class="form-control input-lg" name="username" type="text" placeholder="用户名">
          </div>
          
          <div class="form-group">
            <input class="form-control input-lg" type="password" name="password" placeholder="密码">
          </div>
          
          <div class="form-group">
          保留登陆：
				<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一月 
				
          </div>
          
          
          <div class="form-group">
            <input type="text" name="code" class="form-control input-lg" placeholder="验证码" /> 
          </div>
            <div class="form-group">
            <img src="code.php" class="yzmimg" id="code" />
          </div>
            <div class="form-group last">
            <button type="submit" class="btn btn-success btn-block btn-lg">登陆</button>
          </div>
          
        </form>
        <span id="result" class="alertMsg"></span> </div>
        
        </div>
    </div>
    <!-- // Mailchimp Subscribe form Ends --> 
    <!--  Scroll to Explore --> 
   
    <!-- // Scroll to Explore Ends --> 
  </div>
</main>
<!-- // Parallax Header Ends --> 

<?php
	require ROOT_PATH."includes/footer.inc.php";
			
?>

<!-- Typer --> 
<script src="js/typer.js"></script> 
<script>
    $(function () {
      $('[data-typer-targets]').typer();
    });
  </script> 

<!-- Scroll to Explore --> 

<script>


 $(function() {
    $('.scrollto, .gototop').bind('click',function(event){
		 var $anchor = $(this);
		 $('html, body').stop().animate({
         scrollTop: $($anchor.attr('href')).offset().top
          }, 1500,'easeInOutExpo');
     event.preventDefault();
      });
  });
        

</script>


		