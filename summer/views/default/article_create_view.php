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
            <small><?php echo get_module_path(
                array(
                    array('文章列表', site_url('c=post')),
                    array('编辑文章', '#'),
                    )
            ) ?></small>
        </div>
    </div>
    <div class="am-g" >
        <div class="am-u-12">
                <?php echo validation_errors() ?>
        </div>
        <form action="#" method="post" id="articleForm" class="am-form am-form-horizontal">
            <input type="hidden" value="<?php echo set_value('id', '') ?>" name="id" />
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">标题</label>
                <div class="am-u-sm-6">
                    <input name="title" type="text" value="<?php echo set_value('title') ?>" placeholder="请输入文章标题" />
                    <input type="checkbox" value="<?php echo YES ?>" <?php echo set_checkbox('is_redirect', YES) ?> name="is_redirect" id="is-redirect-checkbox" /> 跳转
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group redirect">
                <label class="am-u-sm-2 am-form-label">转载自</label>
                <div class="am-u-sm-6">
                    <input name="redirect_come_from" type="text" value="<?php echo set_value('redirect_come_from') ?>" placeholder="转载自" placeholder="中国青年网" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group redirect">
                <label class="am-u-sm-2 am-form-label">转载连接</label>
                <div class="am-u-sm-6">
                    <input name="redirect_come_from_url" type="text" value="<?php echo set_value('redirect_come_from_url') ?>" placeholder="http://www.youth.cn" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">类别</label>
                <div class="am-u-sm-6">
                    <select name="category_id" class="category-select">
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo $category['id'] ?>" <?php echo set_select('category_id', $category['id']) ?>><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            
            <div class="am-form-group no-redirect">
                <label class="am-u-sm-2 am-form-label">作者(投稿)</label>
                <div class="am-u-sm-6">
                    <input name="author" type="text" value="<?php echo set_value('author', '') ?>" placeholder="请输入作者" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group no-redirect">
                <label class="am-u-sm-2 am-form-label">关键字</label>
                <div class="am-u-sm-6">
                    <input name="keywords" type="text" value="<?php echo set_value('keywords') ?>" placeholder="请输入关键字，用逗号分开" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">摘要</label>
                <div class="am-u-sm-6">
                    <textarea style="height:150px" name="summary"><?php echo set_value('summary') ?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group no-redirect">
                <label class="am-u-sm-2 am-form-label">正文</label>
                <div class="am-u-sm-8">
                    <div>
                        <script id="container" name="content" style="height:300px" type="text/plain"><?php echo isset($content) && isset($content) ? $content :'' ?></script>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">发布时间</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php echo set_value('publish_date', date(TIME_FORMAT)) ?>" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" placeholder="文章发布时间"  name="publish_date"/>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">状态</label>
                <div class="am-u-sm-8">
                    <div class="checkbox">
                        <label>
                            <input type="radio" value="<?=ARTICLE_STATUS_PUBLIC?>" <?php echo set_radio('status', ARTICLE_STATUS_PUBLIC, true) ?>  name="status" /> 发布
                            <input type="radio" value="<?=ARTICLE_STATUS_DRUFT?>" <?php echo set_radio('status', ARTICLE_STATUS_DRUFT) ?> name="status" /> 草稿
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

        $("#is-redirect-checkbox").on('change', function(e){
            $noRedirect = $(".no-redirect");
            $redirect = $(".redirect");
            if(this.checked) {
                $noRedirect.hide();
                $redirect.show();
            }else{
                $noRedirect.show();
                $redirect.hide();
            }
        });

        function iniRedirect() {
            $noRedirect = $(".no-redirect");
            $redirect = $(".redirect");

            if($('#is-redirect-checkbox').get(0).checked){
                $noRedirect.hide();
                $redirect.show();
            }else{
                $noRedirect.show();
                $redirect.hide();
            }
        }

        iniRedirect();
    });
</script>