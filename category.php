<?php
get_header();
?>
<div class="page-wrapper">
    <main class="site-main container">

        <div class="archive-header">
            <h1 class="page-title"><?php single_term_title() ?></h1>
        </div><!--/.archive-header -->

        <div class="archive-list">

            <?php if ( have_posts() ) : ?>
                <div class="row">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-sm-6 col-lg-4 mb-3">
                            <?php get_template_part( 'template-parts/preview', get_post_type() ); ?>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php theme_the_pagination(); ?>

            <?php else: ?>
                <?php get_template_part( 'template-parts/content', 'none' );  ?>
            <?php endif; ?>

        </div><!--/.archive-list-->

    </main><!--/.site-main.container-->
</div><!--/.page-wrapper-->
<?php
get_footer();