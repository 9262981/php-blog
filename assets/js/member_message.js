window.onload=function(){
	var all=document.getElementById('all');
	var fm=document.getElementsByTagName('form')[0];
	all.onclick=function(){
		//fm.elements获取表单内的所有//表单？减去两个
		for(var i=0;i<fm.elements.length;i++){
			if(fm.elements[i].name!='chkall'){
				fm.elements[i].checked=fm.chkall.checked; 
			}
		}
		
	};
	fm.onsubmit=function(){
			if(confirm('确定批量删除吗？')){
			return true;
		}
		return false;
		};
};
/* 
alert('123'); */