<div class="col-md-3">
	
     <div class="blog-search has-margin-bottom">
        <form method="post" action="search.php?action=search">
		<div class="input-group input-group-lg">
		
		 <input name="search" type="text" class="form-control" placeholder="Search..">
          <span class="input-group-btn">
          <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search glyphicon-lg"></i></button>
          </span> 
		
		</div>
		</form>
      </div>
      <div class="well">
        <h4>全栈之梦</h4>
        <p>有了梦想才能活的快乐.</p>
      </div>
     <div class="well vertical-links has-margin-bottom">
        <h6>文章分类</h6>
        <ul class="list-unstyled">
		<?php 
		$_cid= _query("
					SELECT	*
					FROM pppf_category 
					
					");
		$_htmlcid=array();
		
		while(!!$_rowss=_fetch_array_list($_cid)){
			$_htmlcid['id']=$_rowss['category_id'];
			$_htmlcid['name']=$_rowss['category_name'];
		
		?>	
          <li><a href="category.php?action=cate&id=<?=$_htmlcid['name']?>"><?=$_htmlcid['name']?> <span class="badge pull-right"></span> </a></li>
          
		<?php 
		} 
		_free_result($_cid);
		?>
        </ul>
      </div>
      <!--<div class="tag-cloud has-margin-bottom"> <a href="#">startup</a> <a href="#">landing</a> <a href="#">template</a> <a href="#">website</a> <a href="#">web app</a> <a href="#">mobile</a> <a href="#">coming soon</a> <a href="#">template</a> <a href="#">website/a> <a href="#">launch</a> <a href="#">subscribe</a> <a href="#">signup</a> <a href="blog.html">Blog</a> </div>-->
    </div>
  </div>