<?php
/**
 * iPhoto is evolved from one theme of Tumblr and turned it into photo theme which can be used at typecho.
 * 
 * @package iPhoto
 * @author MuFeng
 * @version 2.0
 * @link http://mufeng.me
 */
 
 $this->need('header.php');
 ?>
	<div id="container">
		<?php while($this->next()): ?>
		<div id="post-<?php $this->the_ID(); ?>" class="post-home">
				<div class="post-thumbnail">
					<?php if(post_thumbnail($this, 0)>0) : ?>
						<a href="<?php $this->permalink(); ?>" title="<?php $this->title(); ?>"><img src="<?php $this->options->themeUrl('timthumb.php'); ?>?src=<?php echo post_thumbnail($this, 1);?>&amp;w=256&amp;zc=1" /></a>
					<?php else : ?>
						<div class="post-noimg">
							<a href="<?php $this->permalink(); ?>" title="<?php $this->title(); ?>"><?php $this->title(); ?></a>
							<p><?php $this->excerpt($this->options->excerptLength, ' ... '); ?></p>
						</div>
					<?php endif; ?>
				</div><!--end .post-thumbnail -->
				<div class="post-info">
					<div class="views"><?php Views_Plugin::theViews(); ?></div>
					<div class="comments"><span><?php $this->commentsNum('0', '1', '%d'); ?></span></div>
					<div class="photos"><span><?php echo post_thumbnail($this, 0); ?></span></div>
				</div><!--end .post-info -->
		</div><!--end .post-home -->
		<?php endwhile; ?>
	</div><!--end #container-->
	<div class="clear"></div>
	<div id="pagenavi">
		<?php $this->pageNav(); ?>
	</div><!--end #pagenavi-->
<?php $this->need('footer.php'); ?>