<div id="recent-news-con">
		<div id="recent-news-left">
		<div id="location-bar">
			<p><i  class="fi-marker location-icon"></i>您的位置：<a id="pos1" href="<?php echo site_url() ?>" >交院新闻网</a> > <?php echo $data['category']['name'] ?></p>
		</div>
			<!--瀑布流  start-->
				<div class="y-photo-container" style="width:660px;">
				<?php foreach($data['articles'] as $v){ ?>
					<div class="y-photo-wrap">
						<a href="<?php echo site_url('photo/archive/'.$v['id']) ?>"><img src="<?php echo base_url($v['photoes'][0] ->src) ?>" /></a>
						<p style="font-size:13px;"><?php echo $v['title'] ?></p>
					</div>
				<?php } ?>
				</div>

		</div>
		<div id="recent-news-right">
			<div id="news-right-con">
				<div class="week-hot">
					<div class="week-hot-tit">
						<p class="hot-tit">一周热点</p>
					</div>
					<div class="hot-content">
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$data['recentList'][0]['id']."&cate=1" ?>" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-01.jpg') ?>" />
							<p><?php echo $data['recentList'][0]['title'] ?></p>	
						</a>
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$data['recentList'][1]['id']."&cate=1" ?>"" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-02.jpg')?>" />
							<p><?php echo $data['recentList'][1]['title'] ?></p>	
						</a>
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$data['recentList'][2]['id']."&cate=1" ?>"" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-03.jpg') ?>" />
							<p><?php echo $data['recentList'][2]['title'] ?></p>	
						</a>
						<ul class="hot-ul">
							<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$data['recentList'][3]['id']."&cate=1" ?>"><?php echo $data['recentList'][3]['title'] ?></a></li>
							<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$data['recentList'][4]['id']."&cate=1" ?>"><?php echo $data['recentList'][4]['title'] ?></a></li>
						</ul>
					</div>
				</div>
				<div class="article-save">
					<div class="article-save-con">
						<div class="week-hot-tit">
							<p class="hot-tit">文章存档</p>
						</div>
						<div class="article-save-ul">
							<ul id="article-list">
								<li><a href="#">2014年12月</a></li>
								<li><a href="#">2015年1月</a></li>
							</ul>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

