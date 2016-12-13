###summer


后端地址：http://localhost/xww/y.php?c=post



##视图

**darticle方法**

darticle($cond)，获取文章列表

$cond 获取文章使用的条件参数

```php

//可以使用的参数如下
array = darticle(
	array(
	'category_id'	=> 1,   //文章分类
	'limit'			=> 1,	//取数据条数
	'offset'		=> 1,	//取数据位移
	'is_top'		=> 0	//是否为置顶文章
	);
)

```

**darticle_detail()**

获取单个文章详细信息，方法必须用到archive/xxx.html页面，archive页面自带一个文章详细全局变量`$article`


##20160809UPDATE

###文章列表页面（桌面端）

路径：index.php/l/1.html（1为文章的category id，分类ID）

模板路径： front/li_view

变量：

- articles  	类型：array  文章列表数组
- pager			类型：string 分页html代码
- title 		类型：string html title标签值
- bread_path    类型：string 面包屑导航
- navs			类型：array  导航栏数组


###文章详情页面（桌面端）

路径：index.php/archive/12-13.html

模板路径：front/archive_view

变量：

- article 		类型：array  文章
- title 		类型：string html title标签值
- navs			类型：array  导航栏数组
- bread_path    类型：string 面包屑导航
- next_article	类型：string 上一条新闻a标签
- prev_article	类型：string 下一条新闻a标签

