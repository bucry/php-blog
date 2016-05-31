<?php
	function post_thumbnail($obj, $f){
        $content = $obj-> text;			
        preg_match_all( "/\<img.*?src\=\"(.*?)\"[^>]*>/i", $content, $thumbUrl );    
        $img_counter = count($thumbUrl[0]);
		if($f==1){
			if( $img_counter > 0 ) {
				$img_src=$thumbUrl [1][0];;
				return $img_src;         
			}
		}else{
			return $img_counter;
		}
    }

	//post.php函数
	function content_thumbnail($obj){
		$url = Helper::options()->siteUrl . 'usr/themes/iphoto/timthumb.php';
        $content = $obj-> text;
		$post_spans = '';
		$post_imgs = '';
        preg_match_all('/\<a.+?href="(.+?)".*?><img.+?src="(.+?)".*?\/><\/a>/is',$content,$matches ,PREG_SET_ORDER);    
		$cnt = count( $matches );
		if($cnt>0){
			if($cnt>1){
				for($i=0;$i<$cnt;$i++){
					$post_current = $i+1;
					$post_img_real = $matches[$i][1];
					$post_img_src = $matches[$i][2];
					
					if($i==0){
						$post_spans .= '<span class="current">'.$post_current.'</span>';
						$post_imgs .= '<img data-real="'.$post_img_real.'" class="current" src="'.$url.'?src='.$post_img_src.'&amp;h=420&amp;zc=1" />';
						$post_real = '<a id="post-real" href="'.$post_img_real = $matches[$i][1].'" target="_blank">查看原图</a>';
					}else{
						$post_spans .= '<span>'.$post_current.'</span>';
						$post_imgs .='<img data-real="'.$post_img_real.'" src="'.$url.'?src='.$post_img_src.'&amp;h=420&amp;zc=1" />';
					}
				}
				$post_img = '<div id="post-img">'.$post_imgs.$post_real.'</div><div id="post-nav">'.$post_spans.'</div>';
			}else{
				$post_img_real = $matches[0][1];
				$post_img_src = $matches [0][2];
				$post_img = '<div id="post-img"><img data-real="'.$post_img_real.'" class="current" src="'.$url.'?src='.$post_img_src.'&amp;h=420&amp;zc=1" /><a id="post-real" href="'.$post_img_real = $matches[0][1].'" target="_blank">查看原图</a></div>';
			}
			echo $post_img;
		}
    }
	
	//主题设置
    function themeConfig($form) {
        $excerptLength = new Typecho_Widget_Helper_Form_Element_Text('excerptLength',NULL,'200','日志截断长度', '首页显示的日志截断长度。');
        $excerptLength->input->setAttribute('class', 'mini');
        $form->addInput($excerptLength->addRule('isInteger', '请填入一个数字')->addRule('required', '请填入一个数字。'));

    }
	
    //自定义评论列表
    function threadedComments($comments,$singleCommentOptions) {
            $author = '<a href="'.$comments->url.'" rel="external nofollow" target="_blank">'.$comments->author.'</a>';
        ?>
	<li id="<?php $comments->theId(); ?>" class="<? if($comments->levels > 0){
                echo 'comment-child';
            }else{
                echo 'comment-parent';
            }
            if($comments->levels > 1){
                echo ' comment-depth';
            }
            ?>">
		<div id="div-<?php $comments->theId(); ?>" class="comment-info">
            <div class="comment-authorinfo">
			    <?php $comments->gravatar(48, 'mm'); ?>
                <div class="comment-text">
                    <span class="comment-author"><?php echo $author; ?></span>
				    <span class="comment-time"><?php $comments->date('Y-m-d H:i:s') ?></span>
                </div>
                <div class="comment-reply">
				    <?php $comments->reply('回复') ?>
                </div>
            </div>
            <div class="comment-content">
                <?php $comments->content(); ?>
            </div>
            <div class="comment-children">
                <?php if ($comments->children) { ?><?php $comments->threadedComments($singleCommentOptions); ?><?php } ?>
            </div>
		</div>
	</li>
<?php } ?>