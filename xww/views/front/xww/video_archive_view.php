<div id="recent-news-con">
		<div id="recent-news-left">
		<div id="location-bar">
			<p><i  class="fi-marker location-icon"></i>您的位置：<a id="pos1" href="<?php echo site_url() ?>" >交院新闻网</a> > <a href="<?php echo site_url('/video/index/') ?>">视频展播</a></p>
		</div>
			<!--瀑布流  start-->
				<div class="y-photo-container" style="width:660px;">

				<div class="cur-news-tit">
					<h3><?php echo $data['article']['title'] ?></h3>
					<p class="cur-news-info" style="font-size:13px;">
						<?php echo date('Y-m-d', $data['article']['add_time']) ?>&nbsp; | &nbsp;发布人：宣传统战部 &nbsp; | &nbsp; 点击:<?php echo $data['article']['hits'] ?> &nbsp;| &nbsp;来稿：<?php echo $data['article']['come_from'] ?>
					</p>
				</div>
				<div id="video" style="margin-top:10px;"></div>
					<script type="text/javascript">
				    var flashvars={
				        f:'<?php echo base_url($data['article']['video_src']) ?>',
				        c:0,
				        loaded:'loadedHandler'
				    };
				    var video=['<?php echo base_url($data['article']['video_src']) ?>'];
				    CKobject.embed('<?php echo base_url('source/ckplayer/ckplayer.swf') ?>','video','ckplayer_a1','650','400',true,flashvars,video);
				</script>
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

