<?php
get_header();
?>
<div class="page-wrapper">
    <main class="site-main">
    <?php
    while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', get_post_type() );
    endwhile;
    ?>
    </main><!--/.site-main-->
</div><!--/.page-wrapper-->
<?php
get_footer();
