<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="content-type" content="text/html; charset=<?php $this->options->charset(); ?>" />
<title><?php if($this->is('index')): ?><?php $this->options->title(); ?><?php else: ?><?php $this->archiveTitle('', '', ''); ?><?php endif; ?></title>
<link rel="shortcut icon" href="<?php $this->options->siteUrl('favicon.ico'); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php $this->options->themeUrl('style.css'); ?>" />
<script type="text/javascript" src="http://code.jquery.com/jquery.js?ver=newest"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('includes/ieonly.js'); ?>"></script>
<?php if($this->is('index') || $this->is('archive')) { ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('includes/jquery.waterfall.min.js'); ?>"></script>
<script type="text/javascript" src="<?php $this->options->themeUrl('includes/index.js'); ?>"></script>
<?php } elseif($this->is('post')) { ?>
<script type="text/javascript" src="<?php $this->options->themeUrl('includes/post.js'); ?>"></script>
<?php }?>
<?php $this->header(); ?>
</head>
<body <?php if($this->is('single')): ?> class="single"<?php endif; ?>>
	<div id="header">
		<div id="header-inner">
			<div id="header-box">
				<div id="logo"><a href="<?php $this->options->siteUrl(); ?>" title="<?php $this->options->title() ?>"><img src="<?php $this->options->themeUrl(); ?>images/logo.png" /></a></div>
				<div id="nav">
					<ul>
						<li<?php if($this->is('index')): ?> class="current"<?php endif; ?>><a href="<?php $this->options->siteUrl(); ?>"><?php _e('首页'); ?></a></li>
						<?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
						<?php while($pages->next()): ?>
						<li<?php if($this->is('page', $pages->slug)): ?> class="current"<?php endif; ?>><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
				<div class="clear"></div>
			</div><!--end header-box-->
		</div>
	</div><!--end header-->
	<div id="wrap">