<div id="recent-news-con" style="overflow: hidden;">
		<div id="recent-news-left">
		<div id="location-bar">
			<p><i  class="fi-marker location-icon"></i>您的位置：<a id="pos1" href="<?php echo site_url() ?>" >交院新闻网</a> > <a id="pos2" href="<?php echo site_url('news/li/'.$content['category_id']) ?>" ><?php echo $content['category_name'] ?></a> > 正文</p>
		</div>
			<div class="news-con-wrap">
				<div class="cur-news-tit">
					<h3><?php echo $content['title'] ?></h3>
					<p class="cur-news-info" style="font-size:13px;">
						<?php echo date('Y-m-d', $content['add_time']) ?>&nbsp; | &nbsp;发布人：宣传统战部 &nbsp; | &nbsp; Hits:<?php echo $content['hits'] ?> &nbsp;| &nbsp;来稿：<?php echo $content['come_from'] ?>
					</p>
				</div>
				<!--
				<div class="cur-news-img">
					<img src="./images/learn-book.jpg" alt="当前新闻图片" />
				</div>-->
				<div class="cur-news-article">
					<?php echo $content['content'] ?>
				</div>
				<div class="share-article" style="border-bottom:solid 1px #dadada;border-top: solid 1px #dadada;padding-left: 20px;padding-top: 15px;overflow: hidden;padding-bottom: 15px;">
					<!-- JiaThis Button BEGIN -->
					<div class="jiathis_style_24x24">
						<a class="jiathis_button_qzone"></a>
						<a class="jiathis_button_tsina"></a>
						<a class="jiathis_button_tqq"></a>
						<a class="jiathis_button_weixin"></a>
						<a class="jiathis_button_renren"></a>
						<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
						<a class="jiathis_counter_style"></a>
					</div>
					<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
					<!-- JiaThis Button END -->
				</div>
				<div class="article-page">
					上一条：<a id="perv" href="<?php echo site_url('news/archive/' . $PreNext['Pre']['id']) ?>"><?php echo $PreNext['Pre']['title'] ?></a><br/>
					下一条：<a id="next" href="<?php echo site_url('news/archive/' . $PreNext['Next']['id']) ?>"><?php echo $PreNext['Next']['title'] ?></a>
				</div>
			</div>
		</div>
		<div id="recent-news-right">
			<div id="news-right-con">
				<div class="week-hot">
					<div class="week-hot-tit">
						<p class="hot-tit">一周热点</p>
					</div>
					<div class="hot-content">
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$recentList[0]['id']."&cate=1" ?>" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-01.jpg') ?>" />
							<p><?php echo $recentList[0]['title'] ?></p>	
						</a>
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$recentList[1]['id']."&cate=1" ?>"" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-02.jpg')?>" />
							<p><?php echo $recentList[1]['title'] ?></p>	
						</a>
						<a target="_blank" id="hot-link" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$recentList[2]['id']."&cate=1" ?>"" >
							<img src="<?php echo  base_url('source/ft/xww/images/hot-03.jpg') ?>" />
							<p><?php echo $recentList[2]['title'] ?></p>	
						</a>
						<ul class="hot-ul">
							<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$recentList[3]['id']."&cate=1" ?>"><?php echo $recentList[3]['title'] ?></a></li>
							<li><a target="_blank" href="<?php echo "http://www.svtcc.edu.cn/newscontent.jsp?id=".$recentList[4]['id']."&cate=1" ?>"><?php echo $recentList[4]['title'] ?></a></li>
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

