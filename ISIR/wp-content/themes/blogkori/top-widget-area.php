<div class="row top-widget-area">
    <div class="col-sm-6">
        <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-top-left')): else: ?>
            <!-- Show default sidebar -->
        <?php endif; ?>
    </div>
    <div class="col-sm-6">
        <?php if(function_exists('dynamic_sidebar') && dynamic_sidebar('sidebar-top-right')): else: ?>
            <!-- Show default sidebar -->
        <?php endif; ?>
    </div>
</div>
