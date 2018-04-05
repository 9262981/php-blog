<?php
/**
 * @Version         2015-10-23 PPPFCMSv1.0.0
 * @Author           apple森马
 * @Copyright      Copyright (c) 2015 - 2020, PPPF.
 * @HomePage    http://www.pppftaobao.com
 * @QQ                9262981
 */
if (!defined('pppf')){
	exit('非法调用');
}
global $_message_html;

?>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">菜单</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="images/logo-small.png" alt="logo"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="index.php">首页</a></li>
			<?php
				if(isset($_COOKIE['username'])){
					echo '<li><a href="member.php">'.$_COOKIE['username'].'个人中心</a>
					</li>'.'<li><a href="member_message.php">消息'.$GLOBALS['message'].'</a>'.'</li>';
				}else{
					echo '<li><a href="register.php">注册</a></li>';
			echo '<li><a href="login.php">登录</a></li>';
				}
			?>
            <?php
				if(isset($_COOKIE['username'])&&isset($_SESSION['admin'])){
					echo '<li><a href="manage.php">管理</a></li>
						  <li><a href="post.php">发文</a></li>';
				}
				if(isset($_COOKIE['username'])){
					echo '<li><a href="logout.php">退出</a></li>';
				
				}
			?>
            
            <!--<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Features <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>-->
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	