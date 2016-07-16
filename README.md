###summer

**darticle方法

darticle($cond)，获取文章列表

$cond 获取文章使用的条件参数

```

darticle(
	array(
	'category_id'	=> 1,   //文章分类
	'limit'			=> 1,	//取数据条数
	'offset'		=> 1,	//取数据位移
	'is_top'		=> 0	//是否为置顶文章
	);
)

```


**darticle_detail()

获取单个文章详细信息，方法必须用到archive/xxx.html页面，archive页面自带一个文章详细全局变量`$article`

