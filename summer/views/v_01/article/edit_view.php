<?php
/**
 * Created by PhpStorm.
 * User: ykjverx
 * Date: 2015/3/12
 * Time: 22:52
 */
?>
<div class="admin-content" style="min-height:1400px;">
    <div class="am-cf am-padding">
        <div class="am-fl am-cf">
            <strong class="am-text-primary am-text-lg"><?php echo $content['moduleName'] ?></strong> /
            <small><?php echo $content['moduleDesc'] ?></small>
        </div>
    </div>
    <div class="am-g" >
        <form id="articleForm" class="am-form am-form-horizontal">
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章标题</label>
                <div class="am-u-sm-6">
                    <input name="title" value="<?php echo $content['article']['title'] ?>" type="text" placeholder="请输入文章标题" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章类别</label>
                <div class="am-u-sm-6">
                    <select name="category">
                        <option value="0">文章类别</option>
                        <?php foreach($content['categories'] as $category){ ?>
                            <option <?php echo ($category['id'] == $content['article']['category_id']) ? 'selected="selected"' : '' ?> value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">来稿</label>
                <div class="am-u-sm-6">
                    <input type="text" value="<?php echo $content['article']['come_from'] ?>" name="comefrom" placeholder="请输入来稿消息" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">作者</label>
                <div class="am-u-sm-6">
                    <input name="author"  value="<?php echo $content['article']['author'] ?>" type="text" placeholder="请输入作者" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">关键字</label>
                <div class="am-u-sm-6">
                    <input name="keywords"  value="<?php echo $content['article']['keywords'] ?>" type="text" placeholder="请输入关键字，用逗号分开" />
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章简介</label>
                <div class="am-u-sm-6">
                    <textarea name="summary" style="height:150px"><?php echo $content['article']['summary'] ?></textarea>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章正文内容</label>
                <div class="am-u-sm-8">
                    <div>
                        <script id="container" name="content" style="height:500px" type="text/plain"><?php echo $content['article']['content'] ?></script>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">发布时间</label>
                <div class="am-u-sm-6">
                    <input type="text"  onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" placeholder="文章发布时间"  value="<?php echo $content['article']['add_time'] ?>"  name="createTime"/>
                </div>
                <div class="am-u-sm-4"></div>
            </div>

            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label">文章状态</label>
                <div class="am-u-sm-8">
                    <div class="checkbox">
                        <label>
                        <?php if($content['article']['status'] == 1){ ?>
                            <input type="radio" checked="checked" value="1" name="status" /> 发布
                            <input type="radio" value="2" name="status" /> 草稿
                        <?php }else{ ?>
                            <input type="radio"value="1" name="status" /> 发布
                            <input type="radio" checked="checked"  value="2" name="status" /> 草稿
                        <?php } ?>
                        </label>
                    </div>
                </div>
                <div class="am-u-sm-2"></div>
            </div>


            <div class="am-form-group">
                <label class="am-u-sm-2 am-form-label"></label>
                <div class="am-u-sm-6">
                    <button type="button" class="am-btn am-btn-default am-radius" id="saveArticle">保存</button>
                </div>
                <div class="am-u-sm-4"></div>
            </div>
            <input type="hidden" id="newsId" name="id" value="<?php echo isset($content['news_id']) ? $content['news_id'] : '' ?>" />
        </form>
    </div>
</div>

<script>
    $(function(){
        var ue = UE.getEditor('container');

        $("#saveArticle").on('click', function(){
            var formData = $("#articleForm").serializeArray();
            formData.push({name : 'content', value : UE.getEditor('container').getContent()});
            $.ajax({
                url : '<?php echo site_url('d=article&c=y&m=create') ?>',
                type : 'post',
                dataType : 'json',
                data : formData,
                success : function(data){
                    if(data.result && data.result == 'success'){
                        $("#newsId").val(data.content.newsId);
                        layer.msg(data.content.msg, 2, 1);
                    }else{
                        layer.msg(data.content, 2);
                    }
                },
                error : function(xhr){
                    $.layer({
                        type : 1,
                        page : {
                            html : xhr.responseText
                        }
                    });
                }
            });
        });
    });
</script>