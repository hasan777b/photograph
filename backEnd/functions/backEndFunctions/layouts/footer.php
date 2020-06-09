<?php $config = config(); ?>
<footer class="footer">
    <span class="d-none d-md-inline-block"> <?php echo !empty($config->footer) ? $config->footer : 'در حال تکمیل...'; ?> </span>
</footer>