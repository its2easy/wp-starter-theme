<?php

?>
<footer class="footer">
    footer
</footer>

</div><!--/.wrap-->

<?php get_template_part( 'partials/modal' ); ?>
<?php wp_footer(); ?>

<?= carbon_get_theme_option( 'crb_body_end_script' ) ?>
<?php //echo get_field( 'theme_body_end_script', 'option' ) ?>
</body>
</html>
