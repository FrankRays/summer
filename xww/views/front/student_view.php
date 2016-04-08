<div class="right">
	<h4>当前位置：<a href="#">首页</a> >>优秀毕业生</h4>
    <div class="detail">
         <p> 人文艺术系是学院人才培养特色突出，发展前景广阔美好的重点建设的专业系之一,人文艺术系高度重视校企合作式人才培养模式的探索与实践,培养德智体美全面发展，掌握各专业必须的文化科学基础知识和专业知识，具有良好的职业道德和综合素质，适应社会主义现代化建设需要的，能应用现代科学技术，具有较强的社会交往能力及创新精神，面向生产,人文艺术系是学院人才培养特色突出，掌握各专业必须的文化面向生产.....</p>
         <?php foreach($studentList as $v) {  ?>
         <div class="szdw">
         	<img width="200" height="240" title="陈斌" src="<?php echo base_url($v['pic_src']) ?>"/>
            <dl>
            	<dd>姓名：<?php echo $v['name'] ?></dd>
                <dd>毕业时间：<?php echo date('Y-m-d',$v['graduate_time']) ?></dd>
                <dd>专业：<?php echo $v['profession'] ?></dd>
            </dl>
            <div class="con">
                <?php echo $v['introl'] ?>
            </div>
            <a href="<?php echo site_url('index.php/student/show/'.$v['id']) ?>">更多>></a>
         </div>
        <?php } ?>
        
         
         <?php echo $this->pagination->create_links(); ?>
    </div>
</div>