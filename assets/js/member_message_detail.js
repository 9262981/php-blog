 window.onload=function(){
	 var ret=document.getElementById('return');
	 var del=document.getElementById('delete');
	 ret.onclick=function(){
		 history.back();
		 location.href='member_message.php';
	 };
	 del.onclick=function(){
		if(confirm('确定删除吗？')){
			location.href='?action=delete&id='+this.name;
		};
	
	 };
 };