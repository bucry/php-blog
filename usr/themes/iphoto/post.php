<?php $this->need('header.php'); ?>
<div id="single-content">
	<div id="post-single">
		<div id="post-<?php $this->the_ID(); ?>" class="post">
			<div class="post-header">
				<?php $this->author->gravatar('48') ?>
				<h1 id="post-title"><?php $this->title(); ?></h1>
				<div id="post-msg">by <?php $this->author() ?>&#160;&#124;&#160;<?php $this->date('M d, Y'); ?>&#160;&#124;&#160;in <?php $this->category(','); ?></div>
			</div>
			<div class="post-content">
				<?php content_thumbnail($this);?>
			</div>
		</div>
		<?php $this->need('comments.php'); ?>
	</div>
	<div id="sidebar">
		<div id="post-msg2">
			<ul>
				<li><?php echo post_thumbnail($this, 0); ?><span class="meta">photos</span></li>
				<li><?php Views_Plugin::theViews(); ?><span class="meta">views</span></li>
				<li><?php $this->commentsNum('0', '1', '%d'); ?><span class="meta">comments</span></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
</div>
<?php $this->need('footer.php'); ?>