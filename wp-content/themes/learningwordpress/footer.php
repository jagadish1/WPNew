<footer class="site_footer">
<?php $args =array('theme_location'=>'footer'); ?>
<?php wp_nav_menu( $args );?>
<p><?php bloginfo('name'); ?> -&copy; <?php echo date('Y'); ?> </p>
</footer>
</div>
<?php wp_footer(); ?>

</body>
</html>
