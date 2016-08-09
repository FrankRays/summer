<?php 


// 

defined('APPPATH') || exit('no access');
echo '<p>';
echo $title;
echo '</p>';
echo '<p>';
echo $bread_path;
echo '</p>';
echo '<ul>';
foreach($articles as $v) {
	echo '<li>';
	echo $v['title'];
	echo '</li>';
}

echo '</ul>';

echo $pager;