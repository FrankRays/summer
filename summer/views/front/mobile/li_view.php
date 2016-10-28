<?php defined('BASEPATH') || exit('no direct script access allowed'); 

require('header_view.php');
?>

	<div class="container">
	    <div class="row" style="margin-top:20px;">
	    	<div class="col-sm-12 summer-index-list-sm" id="summer-article-stream">
				<?php foreach($articles as &$v) { ?>
				<dl>
				    <dt class="artitle_author_date">
				        <div class="summer-index-cat"><?php echo $v['category_name'] ?></div>
				        <div class="summer-index-date"><?php echo substr($v['publish_date'], 0, 10) ?></div>

				    </dt>
				    <?php if( ! empty($v['coverimg_path'])) { ?>
						<dd class="m"><a href="<?php echo archive_url($v)?>"><img src="<?php echo resource_url($v['coverimg_path']) ?>" alt="<?php echo $v['title'] ?>"></a></dd>
				    <?php } ?>
				    <dt class="zjj_title"><a href="<?php echo archive_url($v)?>"><?php echo $v['title']?></a></dt>
				    <dd class="cr_summary"><?php echo $v['summary']?></dd>
				    <dd class="summer-index-tail">
				            <span class="summer-index-like"><?php echo $v['love']?></span>
				            <span class="summer-index-hits"><?php echo $v['hits']?></span>
				    </dd>
				</dl>
				<?php } ?>
	    	</div>
	    </div>
    </div>

	<!-- //引入footer -->
	<?php require('footer_view.php') ?>
	<!-- //引入footer -->
  </body>

 <!-- jQuery -->
<script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- Bootstrap  -->
<script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<!-- layer ui good luck -->
<script type="text/javascript" src="<?php echo static_url('plugins/layui/layui.js') ?>"></script>

<script type="text/javascript">
    layui.use(['flow'], function(){
        var flow = layui.flow
        ,$ = layui.jquery
        ,category_id = <?php echo isset($category) ? $category['id'] : 0 ?>;

        flow.load({
            elem : '#summer-article-stream'
            ,isAuto : false
            ,done : function(page, next) {
                var artilesLis = [];
                if(category_id !== 0) {
                    $.get("<?php echo site_url('welcome/load_flow_article') ?>?page=" + page + "&category_id=" + category_id,
                        function(res){
                            next(res, res.length == '');
                        });
                }
            }
        });
    });
</script>
</html>
