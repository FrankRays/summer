<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/23
 * Time: 20:32
 */

?>

<div class="admin-content" style="min-height:1400px;">
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
        <form id="photoForm" action="#" method="post" class="am-form am-form-horizontal">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章标题</label>
                <div class="am-u-sm-6">
                    <input name="title" value="<?php echo set_value('title') ?>" type="text" placeholder="请输入文章标题" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章类别</label>
                <div class="am-u-sm-6">
                    <select name="category_id" class="category-select">
                        <option value="0">文章类别</option>
                        <?php foreach($categories as $category){ ?>
                            <option <?php echo set_select('category_id', $category['id']) ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">来稿</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php echo set_value('come_from') ?>" name="comefrom" placeholder="请输入来稿消息" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">作者</label>
                <div class="am-u-sm-6">
                    <input name="author" value="<?php echo set_value('author') ?>" type="text" placeholder="请输入作者" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">关键字</label>
                <div class="am-u-sm-6">
                    <input name="keywords" value="<?php echo set_value('keywords') ?>" type="text" placeholder="请输入关键字，用逗号分开" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章简介</label>
                <div class="am-u-sm-6">
                    <textarea style="height:150px" name="summary"><?php echo set_value('summary')?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">图片列表</label>   
                <div class="am-u-sm-10">                 
                    <div class="am-btn-toolbar">
                            <div class="am-btn-group">
                                <button type="button"  class="am-btn am-btn-default am-btn-sm" id="summer-photo-upload-btn"><span class="am-icon-save"></span>添加图片</button>
                            </div>
                    </div>
                    <table class="am-table am-table-striped am-table-hover table-main upload-img-table" id="y-article-list">
                        <thead>
                            <tr>
                                <th>图片</th>
                                <th>简介</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody id="article-tbody">
                            <?php if(isset($article['article_image_array'])) { 
                                foreach($article['article_image_array'] as $v) { ?>
                                <tr>
                                <td><img src="<?=$v['file_uri']?>" /></td>
                                <td><textarea><?=$v['summary']?></textarea></td>
                                <td>
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                    <button type="button" class="am-btn am-btn-xs delete-image-btn" >删除</button>
                                    <button type="button" class="am-btn am-btn-xs upward-image-btn" >上移</button>
                                    <button type="button" class="am-btn am-btn-xs downward-image-btn" >下移</button>
                                    </div>
                                </div>
                                </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>

                    <div style="display:none">
                        <script id="container" name="content" style="height:500px" type="text/plain"></script>
                    </div>

                    <input type="hidden" id="article-image-input" name="article_image" value="<?=set_value('article_image')?>"/>
                </div>
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
                    <button type="submit" class="am-btn am-btn-default am-radius" id="savePhoto">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?=set_value('id') ?>" />
        </form>
    </div>
</div>

<script type="text/javascript" src="<?=base_url('statics/plugins/uploadimg/js/xww.uploadimg.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('statics/plugins/uploadimg/css/xww.uploadimg.css')?>">
<script>
    $(function(){

        var cateSelect = $('.category-select').chosen({
                max_selected_options: 1
            });

        var imageUploader = WebUploader.create({
            "server" : "<?=site_url('c=file&m=articlePhoto') ?>",
            "swf" : "<?=base_url('static/plugins/webuploader/Uploader.swf') ?>",
            "resize" : false,
            "accept" : {
                "title" : "Images",
                "extensions" : "gif,jpg,jpeg,bmp,png",
                "mimeTypes" : "image/*"
            },
            "pick" : {
                "id" : "#summer-photo-upload-btn",
                "style" : ""
            },
            "auto" : true
        });

        //submit event
        $("#photoForm").on("submit", function(e, form){
            var articleImages = [];
            $("#article-tbody").find("tr").each(function(k, v){
                articleImages[k] = {
                    "file_uri" : $(v).find("img").attr("src"),
                    "summary" : $(v).find("textarea").val()
                };
            });
            $("#article-image-input").val(JSON.stringify(articleImages));
        });

        var noStylePicBtn = $(".webuploader-pick");
        noStylePicBtn.removeClass("webuploader-pick");
        noStylePicBtn.attr("style", "background:none");

        $(".upload-img-table").xwwUploadImg({
            "webuploader" : imageUploader
        });
    });
</script>