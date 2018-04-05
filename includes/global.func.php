<?php
/**
 * @version         2015-10-23 PPPFCMSv1.0.0
 * @author           apple森马
 * @copyright      Copyright (c) 2015 - 2020, PPPF.
 * @homepage    http://www.pppftaobao.com
 */
 //管理登陆判断
 function _manage_login(){
	 if((!isset($_COOKIE['username']))||(!isset($_SESSION['admin']))){
		 _location('非系统管理员','login.php');
	 }
 }
 /////////////
function _timed($now_time,$pre_time,$second){
	if($now_time-$pre_time<$second){
		_alert_back('发帖间隔低于'.$second.'秒');
	}
}
//_html()函数表示对字符串，进行html过滤显示
function _html($_string){
		if(is_array($_string)){
			foreach($_string as $_key => $_value){
				$_string[$_key]=_html($_value);
			}
		}else{
		$_string = htmlspecialchars($_string);
	}
	return $_string;
}

function delHtmlTag($str)
{
 $str = preg_replace( "@<img(.*?)>@is", "", $str ); 
 return  $str;
}
//////转义转义 SQL 语句中使用的字符串中的特殊字符，并考虑到连接的当前字符集 
function _mysql_string($_string){
	if (!GPC){	
		if(is_array($_string)){
			foreach($_string as $_key => $_value){
				$_string[$_key]=_mysql_string($_value);
			}
		}else{
		$_string = mysql_real_escape_string($_string);
	}
	}
	return $_string;
}
	

function _free_result($_result){
	mysql_free_result($_result);
}
 /* 
	*_runtime()是用来获取执行耗时
	*@access public 表示函数对外公开
	*@return float 表示返回出来的是一个浮点数
	microtime — 返回当前 Unix 时间戳和微秒数 
	explode — 使用一个字符串分割另一个字符串 
 */
	function _runtime(){
	$_mtime = explode(" ",microtime());
	return $_mtime[1] + $_mtime[0];
	}
 /* 
	*_alert_back()是JS弹窗
	*@access public 表示函数对外公开
	*@param(参数) $_info
	*@return void 弹窗
 */	
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
		exit();
	}
	function _alert_close($_info){
		echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
		exit();
	}	
	function _location($_info,$_url){
		if(!empty($_info)){
		echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
		exit();
		}else{
			header('Location:'.$_url);
	}
	}
////////写入xml文件////////
	
function _set_xml($_xmlfile,$_clean){
	
		 $_fp=@fopen('new.xml','w');
			if(!$_fp){
				exit('文件不存在03');
			}
		 flock($_fp,LOCK_EX);
		 $_string="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
		 
		 fwrite($_fp,$_string,strlen($_string));
		 $_string="<vip>\r\n";
		 
		 fwrite($_fp,$_string,strlen($_string));
		 $_string="<id>{$_clean['id']}</id>\r\n";
		 
		 fwrite($_fp,$_string,strlen($_string));
		 $_string="<username>{$_clean['username']}</username>\r\n";
		 
		 fwrite($_fp,$_string,strlen($_string));
		  $_string="<sex>{$_clean['sex']}</sex>\r\n";
		  
		 fwrite($_fp,$_string,strlen($_string));
		  $_string="<face>{$_clean['face']}</face>\r\n";
		  
		 fwrite($_fp,$_string,strlen($_string));
		  $_string="<email>{$_clean['email']}</email>\r\n";
		  
		 fwrite($_fp,$_string,strlen($_string));
		  $_string="<url>{$_clean['url']}</url>\r\n";
		  
		 fwrite($_fp,$_string,strlen($_string));
		  $_string="</vip>";
		 fwrite($_fp,$_string,strlen($_string));
		 
		 flock($_fp,LOCK_UN); 
		 fclose($_fp);
}
	
function _get_xml($_xmlfile){
	$_html=array();
	if(file_exists($_xmlfile)){
		$_xml=file_get_contents($_xmlfile);
		preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
		foreach($_dom[1] as $_value){
		preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
		preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
		preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
		preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
		preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
		preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);
		
		$_html['id']=$_id[1][0]; 
		$_html['username']=$_username[1][0]; 
		$_html['sex']=$_sex[1][0]; 
		$_html['face']=$_face[1][0]; 
		$_html['email']=$_email[1][0]; 
		$_html['url']=$_url[1][0]; 
 
		}
	}else{
		echo '文件不存在';
	}
	return $_html;
}

function _ubb($_string){
	$_string=nl2br($_string);
	$_string=preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px">\2</span>',$_string);
	$_string=preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
	$_string=preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
	$_string=preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline">\1</span>',$_string);
	$_string=preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through">\1</span>',$_string);
	$_string=preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
	$_string=preg_replace('/\[url\](.*)\[\/url\]/U','<a href="\1" target="_blank">\1</a>',$_string);
	$_string=preg_replace('/\[email\](.*)\[\/email\]/U','<a href="mailto:\1" >\1</a>',$_string);
	$_string=preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1"></img>',$_string);
	$_string=preg_replace('/\[flash\](.*)\[\/flash\]/U','<embed style="width:480px;height:400px" src="\1"></embed>',$_string);
	return $_string;
}

function _session_destroy() {
	session_destroy();
}


//UNIQID
//比对唯一标识符防止cookie伪造
function _uniqid($_mysql_uniqid,$_cookie_uniqid){
		if($_mysql_uniqid!=$_cookie_uniqid){
			_alert_back('异常登录1623');
			}
		}



/**
 * 删除cookies   _unsetcookies()
 */

function _unsetcookies() {
	setcookie('username','',time()-1);
	setcookie('uniqid','',time()-1);
	//_session_destroy();
	_location(null,'index.php');
}
/*
登陆状态*/
function _login_state() {
if(isset($_COOKIE['username'])){
					_alert_back('登录状态无法进行本操作');
				
				}
}

///
///$ absolute总页数///
///$_num 多少个会员////
///$_pagesize 一个页面显示多少条数据///
///$_page get获取当前页码
///$_pageabsolute 会员数除pagesize取余 有多少个页面
function _page($_sql,$_size){
	global $_page,$_pageabsolute,$_pagesize,$_pagenum,$_num;
					if(isset($_GET['page'])){
						$_page=$_GET['page'];
						if(empty($_page)||$_page<=0||!is_numeric($_page)){
						$_page=1;}else{
							$_page=intval($_page); 
						}
						}else{
							$_page=1;
						}
					$_pagesize=$_size;//每页多少条

					$_num=_num_rows(_query($_sql));
					
					if($_num==0){
						$_pageabsolute=1;
					}else{
						$_pageabsolute=ceil($_num/$_pagesize);//页码ceil进一法取整
					//mysql_num_rows — 取得结果集中行的数目 
					}
					if($_page>$_pageabsolute){
						$_page=$_pageabsolute;
					}
					$_pagenum=($_page-1)*$_pagesize;//从第几条开始
}
//分页函数
//@param $_type
//@return 返回分页
///$_pageabsolute总页数///
///$_num 多少个会员////
///$_pagesize 一个页面显示多少条数据///
///$_page get获取当前页码
///$_pageabsolute 会员数除pagesize取余 有多少个页面
function _paging($_type){
	global $_id,$_page,$_pageabsolute,$_num;
	if($_type==1){
		
					 for($i=0;$i<$_pageabsolute;$i++) {
						  if($_page==$i+1){
							  echo '<li class="active"><a href="#">'.($i+1).'<span class="sr-only">(current)</span></a></li>'; 
						
							  } else{
								   echo '<li ><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>'; 
							  }
							
					 } 
					
	}	elseif($_type==2){
		
					if($_page==1){
						echo '<li class="previous-off">首页</li>';
						echo '<li class="previous-off">上页</li>';
					}else{
						echo '<li class="disabled"><a href="'.SCRIPT.'.php">首页</a></li>';
						echo '<li class="previous"><a href="'.SCRIPT.'.php?'.$_id.'page='.($_page-1).'">上页</a></li>';
					}
				
					if($_page==$_pageabsolute){
						echo '<li class="previous-off">下页</li>';
						echo '<li class="previous-off">尾页</li>'; 
					}else{
						echo '<li class="previous"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$_id.'page='.($_page+1).'">下页</a></li>';
						echo '<li class="previous"><a href="'.$_SERVER['SCRIPT_NAME'].'?'.$_id.'page='.$_pageabsolute.'">尾页</a></li>';						
					}
					echo '<li class="next-off">共有'.$_num.'条数据 页码'.$_page.'/'.$_pageabsolute.'</li>';
	}
}
	
	
	
/*
唯一标识符
  */
	function _sha1_uniqid(){
		return _mysql_string(sha1(uniqid(rand(),true)));
	}
	
/* 
	*@_mysql_string
	*@param string $_string
	*@return string $_string
	//mysql_real_escape_string — 转义 SQL 语句中使用的字符串中的特殊字符，并考虑到连接的当前字符集 
 */
	
/**
 * _title()标题截取函数
 * @param $_string
 mb_strlen根据字符数执行一个多字节安全的 substr()  操作。 位置是从 str 的开始位置进行计数。 第一个字符的位置是 0。第二个字符的位置是 1，以此类推。
 */

function _title($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8') > $_strlen) {
		$_string = mb_substr($_string,0,$_strlen,'utf-8').'...';
	}
	return $_string;
}
function _describe($_string,$_strlen) {
	if (mb_strlen($_string,'utf-8') > $_strlen) {
		$_string = mb_substr($_string,0,$_strlen,'utf-8').'...';
	}
	
	return $_string;
	
	
}

/* 
	*@_check_code 验证码
	*@param string $_first_code
	*@param string $_end_code
	*@return void 验证码比对
 */
	function _check_code($_first_code,$_end_code){
		 if($_first_code != $_end_code){
			 _alert_back('验证码不正确!');
		 }
	}
	
 /* 
	验证码_code函数
	*@access public
	*@param参数 int $_width 表示验证码长度
	*@param int $_height 表示验证码高度
	*@param int $_md_code 表示验证码位数
	*@return void 这个函数执行产生验证码
*/
	function _code($_width,$_height,$_md_code){
		//随机码个数
		
		//消除报错信息//
		 ini_set("error_reporting","E_ALL & ~E_NOTICE");
			for ($i=0;$i<$_md_code;$i++){
				$_nmsg.=dechex(mt_rand(0,15));
				
				
			}
		//保存在session//
			$_SESSION['code']=$_nmsg;
			
		//创建一张图像//
			
			$_img=imagecreatetruecolor($_width,$_height);
		//白色 创建一个画笔而已
			$_white=imagecolorallocate($_img,255,255,255);
		//填充背景 用画笔填充颜色
			imagefill($_img,0,0,$_white);
		//创建一个边框
			$_md_color = imagecolorallocate($_img,mt_rand(0,55),mt_rand(0,55),mt_rand(0,55));
			imagerectangle($_img,0,0,$_width-1,$_height-1,$_md_color);
		//随机画出6个线条
			for($i=0;$i<6;$i++){
				$_md_color = imagecolorallocate($_img,mt_rand(100,255),mt_rand(100,255),mt_rand(110,255));
				imageline($_img,mt_rand(0,$_width),mt_rand(0,$_height),mt_rand(0,$_width),mt_rand(0,$_height),$_md_color);
			}  
		//随机雪花
			for ($i=0;$i<11;$i++){
			$_md_color = imagecolorallocate($_img,mt_rand(100,255),mt_rand(100,255),mt_rand(110,255));
			$_mb_color = imagecolorallocate($_img,mt_rand(0,155),mt_rand(100,155),mt_rand(110,155));
			imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'*',$_md_color);
			}
			for ($i=0;$i<5;$i++){
			$_md_color = imagecolorallocate($_img,mt_rand(100,255),mt_rand(100,255),mt_rand(110,255));
			$_mb_color = imagecolorallocate($_img,mt_rand(0,155),mt_rand(100,155),mt_rand(110,155));
			imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'#',$_md_color);
			}
			for ($i=0;$i<5;$i++){
			$_md_color = imagecolorallocate($_img,mt_rand(100,255),mt_rand(100,255),mt_rand(110,255));
			$_mb_color = imagecolorallocate($_img,mt_rand(0,155),mt_rand(100,155),mt_rand(110,155));
			imagestring($_img,1,mt_rand(1,$_width),mt_rand(1,$_height),'@',$_md_color);
			}
		//输出验证码
			for($i=0;$i<strlen($_SESSION['code']);$i++){
				//5号字体
				imagestring($_img,5,$i*$_width/$_md_code+mt_rand(10,20),mt_rand(1,$height/2),$_SESSION['code'][$i],$_mb_color);
			}
		//输出图像//
			header('Content-Type:image/png');
			imagepng($_img);
		//销毁图像//
			imagedestroy($_img);
	}
?>