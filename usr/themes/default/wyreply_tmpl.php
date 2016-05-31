<?php
     $this->need('header.php');
?>
<style type="text/css">
    #wypanel #commentlist ul {
        text-align:right;
    }
    #wypanel #commentlist ul li {
        list-style:none;
        margin: 10px 5px 0 0;
        font-size:10px;
        padding:5px 10px 5px 10px;
        border:1px dashed #eee;
    }
    #wypanel #commentlist ul li .msg {
        font-size:12px;
        margin-bottom:5px;
        word-wrap:break-word;
        text-align:left;
    }
</style>
<div class="col-mb-12 col-8" id="wypanel">
    <article class="post">
        <p class="post-title"><?php _e("{微语}") ?></p>
        <div class="post-content"><?php $this->title() ?></div>
    <hr style="color:#e9e9e9;margin-top:20px;">
    <div id="commentlist">
        
    </div>
    <div class="respond">
        <input type="hidden" id="msgId" value="<?php $this->msgId(); ?>" />
        <?php _e('发表评论'); ?>
        <p>
            <label for="author" class="required"><?php _e('称呼'); ?></label>
            <input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
        </p>
        <p>
            <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('Email'); ?></label>
            <input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
        </p>
        <p>
            <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
            <input type="url" name="url" id="url" class="text" placeholder="<?php _e('http://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
        </p>
        <p>
            <label for="textarea" class="required"><?php _e('内容'); ?></label>
            <textarea rows="8" cols="50" name="text" id="textarea" class="textarea" required ><?php $this->remember('text'); ?></textarea>
        </p>
        <p>
            <button type="button" class="submit" id="btnCommit"><?php _e('提交评论'); ?></button>
        </p>
    </div>
    </article>
</div><!-- end #main-->

<?php $this->need('sidebar.php'); ?>
<?php
$jqUrl = Typecho_Common::url('js/jquery.js', $this->options->adminUrl);
echo "<script type='text/javascript' src='${jqUrl}'></script>";
?>
<script type="text/javascript">
    var loadComments = function() {
        var msgId = $("#msgId").val();
        var postUrl = "<?php $this->options->index('/action/weiyu-add'); ?>";
        $.ajax({
            url:postUrl,
            data:{"opt":"commentlist","msgId":msgId},
            dataType:"json",
            method:"GET",
            success:function(data) {
                if (data) {
                    var listdiv = $("<ul>");
                    var len = data.length;
                    for (var i = 0; i < len; i++) {
                        var li = $("<li>");
                        var item = data[i];
                        li.append($("<div>").text(item.content).addClass("msg"));
                        var auther = $("<a>").text(item.nickname).attr("href", "mailto:" + item.email);
                        li.append("<span>-- by </span>").append(auther);
                        listdiv.append(li);
                    }
                    $("#wypanel #commentlist").html(listdiv);
                } else {
                    //alert("无评论");
                }
            },
            error:function(xhr, status) {
                //alert("获取评论出错:" + status);
            }
        });
    };
    loadComments();
    $("#wypanel #btnCommit").click(function() {
        //alert($("#textarea").val());return;
        var msgId = $("#msgId").val();
        var nickname = $("#author").val();
        var email = $("#mail").val();
        var website = $("#url").val();
        var content = $("#textarea").val();
        if (!nickname || !email || !content) {
            alert("填写信息不完整");
            return;
        }
        var postUrl = "<?php $this->options->index('/action/weiyu-add'); ?>";
        $.ajax({
            url:postUrl,
            data:{"opt":"addcomment","nickname":nickname,"email":email,"website":website,"ccontent":content,"msgId":msgId},
            dataType:"json",
            method:"GET",
            success:function(data) {
                //alert("评论成功");
                loadComments();
            },
            error:function() {
                alert("发表评论失败");
            }
        });
    });
</script>
<?php $this->need('footer.php'); ?>