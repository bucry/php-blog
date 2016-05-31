<?php
include 'common.php';
include 'header.php';
include 'menu.php';
?>
<style type="text/css">
    .WeiYu_KGSOFT {
        position:relative;
        margin:0 auto;
        display:block;
        width:700px;
        min-height:300px;
        margin-top:50px;
    }
    .WeiYu_KGSOFT #weiyu {
        width:100%;
    }
    .WeiYu_KGSOFT #btnAdd {
        margin-top:5px;
        float:right;
        height:40px;
    }
    .WeiYu_KGSOFT footer {
        font-size:12px;float:right;
        text-align:right;
        width:100%;
        margin-top:100px;
    }
    .WeiYu_KGSOFT #msg {
        font-size:14px;
        line-height:40px;
        float:right;margin-right:20px;
        color:#15A230;padding-top:5px;
    }
    .WeiYu_KGSOFT table {
        float:left;
        display:inline-block;
        color:#717171;
        margin-top:50px;
    }
    .WeiYu_KGSOFT table tr {
        border-top: 1px dashed #999;
        border-bottom: 1px dashed #999;
    }
    .WeiYu_KGSOFT table .tdDel {
        min-width:120px;
    }
    .WeiYu_KGSOFT table .btnDel,.WeiYu_KGSOFT table .btnDelComment {
        color:#006633;
        cursor: pointer;
        margin-left:20px;
    }
    .WeiYu_KGSOFT table .btnComment,.WeiYu_KGSOFT table .noComment {
        margin-left:5px;
        padding-left:5px;
        border-left: 1px solid #333;
    }
    .WeiYu_KGSOFT table li {
        list-style:none;
        padding-left:10px;
        border-left: 4px solid #999;
        margin-top:5px;
        font-size:14px;
        line-height:14px;
    }
    .WeiYu_KGSOFT table li .commentMsg {
        display:inline-block;
        margin-right:20px;
        max-width:600px;
        overflow:hidden;
        word-wrap:break-word;
        text-overflow:ellipsis;
    }
    .WeiYu_KGSOFT table li .nickname {
        text-align:right;
        display:inline-block;
        margin-left:5px;
        color:#8A1F11;
        font-size:12px;
        line-height:14px;
    }
    .WeiYu_KGSOFT table .sublist {
        border-bottom: 0px dashed #999;
    }
</style>
<div class="main">
    <div class="body container">
        <?php include 'page-title.php'; ?>
        <div class="colgroup typecho-page-main" role="main">
            <div class="col-mb-12">
                <div class="WeiYu_KGSOFT">
                    <input id="weiyu" type="text" placeholder="请输入新的微语"/>
                    <button id="btnAdd" type="button">设置微语</button>
                    <span id="msg"></span>
                    <input type="hidden" id="msgdata" value='<?php echo Typecho_Widget::widget("TEWeiYu_Action")->getMsg(); ?>' />
                    <div class="msglist">
                    </div>
                    <footer>
                        <p>本插件由<a href="http://www.blog.kgsoft.cn" target="_blank">一介码农</a>提供，感谢使用!</p>
                        <p>如有问题或建议请发<a href="mailto:rushi_wowen@163.com">邮件</a></p>
                    </footer>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'copyright.php';
include 'common-js.php';
include 'footer.php';
?>

<script>
    var drawweiyutable = function(weiyuData) {
        //var weiyuData = $(".WeiYu_KGSOFT #msgdata").val();
        var c = $(".WeiYu_KGSOFT .msglist").empty();
        if (weiyuData == null) {
            return;
        }
        //weiyuData = eval("(" + weiyuData + ")");
        var table = "<table>";
        for (var i = 0; i < weiyuData.length; i++) {
            var item = weiyuData[i];
            if (item) {
                var id = item.id + "";
                var comments = item.comments;
                var commentCnt = comments ? comments.length : 0;

                if (commentCnt > 0) {
                    table += "<tr class='sublist'><td><span>" + item.msg + "</span></td><td class='tdDel'><span class='btnDel' onclick='javascript:removeWeiYu(\"" + id + "\");'>删除</span>";
                    table += "<span  class='noComment'>评论(" + commentCnt + ")</span>";
                    table +="</td></tr>";
                    //add comment list
                    table += "<tr><td colspan=2><ul>";
                    for (var j = 0; j < commentCnt; j++) {
                        var cmt = comments[j];
                        table += "<li><span class='commentMsg'>" + cmt.content + "</span><span class='nickname'>-- " + cmt.nickname + "</span><span class='btnDelComment'  onclick='javascript:removeWeiYuComment(\"" + id + "\"," + j + ");'>删除此评论</span></li>";
                    }
                    table += "</ul></td></tr>";
                } else {
                    table += "<tr><td><span>" + item.msg + "</span></td><td class='tdDel'><span class='btnDel' onclick='javascript:removeWeiYu(\"" + id + "\");'>删除</span>";
                    table += "<span class='noComment'>无评论</span>";
                    table +="</td></tr>";
                }
            }
        }
        table += "</table>";
        c.html(table);
    }
    var getWeiyuList = function(callback) {
        var postUrl = "<?php $options->index('/action/weiyu-add'); ?>";
        $.ajax({
            url:postUrl,
            data:{"opt":"list"},
            dataType:"json",
            method:"GET",
            success:function(data) {
                $(".WeiYu_KGSOFT #msgdata").val(data);
                drawweiyutable(data);
                if (callback) {
                    callback(data);
                }
            },
            error:function() {
                //alert("获取微语列表错误");
            }
        });
    };
    var removeWeiYuComment = function(id, index) {
        if (! confirm("确认删除？")) {
            return;
        }
        var postUrl = "<?php $options->index('/action/weiyu-add'); ?>";
        $.ajax({
            url:postUrl,
            data:{"id":id,"index":index,"opt":"delComment"},
            method:"POST",
            success:function(data) {
                getWeiyuList();
            }
        });
    };
    var removeWeiYu = function(id) {
        if (! confirm("确认删除？")) {
            return;
        }
        var postUrl = "<?php $options->index('/action/weiyu-add'); ?>";
        $.ajax({
            url:postUrl,
            data:{"id":id,"opt":"del"},
            method:"POST",
            success:function(data) {
                getWeiyuList();
            }
        });
    };

    (function() {
        getWeiyuList();
        $(".WeiYu_KGSOFT #btnAdd").click(function() {
            var val = $("#weiyu").val();
            var postUrl = "<?php $options->index('/action/weiyu-add'); ?>";
            $.ajax({
                url:postUrl,
                data:{"msg":val,"opt":"add"},
                method:"POST",
                success:function(data) {
                    //alert(data);
                    getWeiyuList();
                },
                error:function() {
                    alert("添加失败");
                }
            });
        });
    })();
</script>