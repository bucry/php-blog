<div id="comments">
            <?php $this->comments()->to($comments); ?>
            <?php if ($comments->have()): ?>            
            <?php $comments->pageNav(); ?>
            
            <?php $comments->listComments(); ?>
            
            <?php endif; ?>

            <?php if($this->allow('comment')): ?>
            <div id="<?php $this->respondId(); ?>" class="respond">
            
            <div class="cancel-comment-reply">
            <?php $comments->cancelReply(); ?>
            </div>
            
			<form method="post" action="<?php $this->commentUrl() ?>" id="comment_form">
                <?php if($this->user->hasLogin()): ?>
				<p class="title welcome">
                    <?php _e('欢迎 '); ?> <a href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a><?php _e(' 归来！ '); ?><a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出 »'); ?></a>
                    <span class="cancel-comment-reply"><?php $comments->cancelReply(); ?></span>
                </p>
                <?php else: ?>
                <?php if($this->remember('author',true) != "" && $this->remember('mail',true) != "") : ?>
                <p class="title welcome">
                    <?php _e('欢迎 '); ?><strong><?php $this->remember('author'); ?></strong><?php _e(' 归来！ '); ?>
                    <span class="cancel-comment-reply"><?php $comments->cancelReply(); ?></span>
                </p>
                <div class="author_info" style="display:none;">
                <?php else : ?>
                <div class="author_info">
                <?php endif ; ?>
				<p>
					<input type="text" name="author" id="author" class="text" size="15" value="<?php $this->remember('author'); ?>" />
                    <label for="author"><small><?php _e('称呼：'); ?></small></label>
				</p>
				<p>
					<input type="text" name="mail" id="email" class="text" size="15" value="<?php $this->remember('mail'); ?>" />
                    <label for="mail"><small><?php _e('邮箱：'); ?></small></label>
				</p>
				<p>
					<input type="text" name="url" id="url" class="text" size="15" value="<?php $this->remember('url'); ?>" />
                    <label for="url"><small><?php _e('网站：'); ?></small></label>
				</p>
                </div>
                <?php endif; ?>
<div id="author_textarea">
<textarea rows="5" cols="50" name="text" id="comment" class="textarea"><?php $this->remember('text'); ?></textarea>
<input type="submit" value="<?php _e('提交评论/Ctrl+Enter'); ?>" id="submit" class="submit" />
</div>
			</form>
            </div>
            <?php else: ?>
            <h4><?php _e('评论已关闭'); ?></h4>
            <?php endif; ?>
		</div>
