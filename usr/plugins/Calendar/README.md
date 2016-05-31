<?php if (class_exists("Calendar_Plugin")): ?>
    <div class="list-group">
        <a class="list-group-item active"><i class="fa fa-calendar fa-fw"></i> <?php _e('日历');?></a>
        <?php Calendar_Plugin::render();?>
    </div>
<?php endif;?>
