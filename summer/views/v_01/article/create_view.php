<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */
?>
<div class="admin-content">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $moduleName ?></strong> /
            <small><?php echo $moduleDesc ?></small>
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>
        <form action="#" method="post" id="articleForm" class="am-form am-form-horizontal">
            <input type="hidden" value="<?php echo set_value('id', '') ?>" name="id" />
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章标题</label>
                <div class="am-u-sm-6">
                    <input name="title" type="text" value="<?php echo set_value('title') ?>" placeholder="请输入文章标题" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章类别</label>
                <div class="am-u-sm-6">
                    <select name="category_id" class="category-select">
                        <option value="0">文章类别</option>
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo $category['id'] ?>" <?php echo set_select('category_id', $category['id']) ?>><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">来稿</label>
                <div class="am-u-sm-6">
                    <input type="text" name="come_from" value="<?php echo set_value('come_from', '') ?>" placeholder="请输入来稿消息" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">作者</label>
                <div class="am-u-sm-6">
                    <input name="author" type="text" value="<?php echo set_value('author', '') ?>" placeholder="请输入作者" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">关键字</label>
                <div class="am-u-sm-6">
                    <input name="keywords" type="text" value="<?php echo set_value('keywords') ?>" placeholder="请输入关键字，用逗号分开" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章简介</label>
                <div class="am-u-sm-6">
                    <textarea style="height:150px" name="summary"><?php echo set_value('summary') ?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章正文内容</label>
                <div class="am-u-sm-8">
                    <div>
                        <script id="container" name="content" style="height:500px" type="text/plain"><?php echo isset($article) && isset($article['content']) ? $article['content'] :'' ?></script>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">发布时间</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php echo set_value('add_time', date('Y-m-d H:i:s')) ?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" placeholder="文章发布时间"  name="add_time"/>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章状态</label>
                <div class="am-u-sm-8">
                    <div class="checkbox">
                        <label>
                            <input type="radio" <?php echo set_radio('status', '1', true) ?> value="1" name="status" /> 发布
                            <input type="radio" <?php echo set_radio('status', '2') ?> value="2" name="status" /> 草稿
                        </label>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>


            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="submit" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
        </form>
    </div>

</div>


<script>
    $(function(){
        var ue = UE.getEditor('container', 
            {
                'serverUrl': "<?=site_url('c=file&m=uEditorUpload')?>"
            });
        var cateSelect = $('.category-select').chosen({
                max_selected_options: 1
            });
    });
</script>