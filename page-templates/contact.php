<?php
/**
 * Template Name: Шаблон Контакты
 */

get_header();
?>
<div class="page-wrapper">
    <main class="site-main">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('page-entry'); ?>>

                <div class="page-header container">
                    <h1 class="page-title"><?= get_the_title(); ?></h1>
                </div><!--/.page-header -->

                <div class="page-content container">
                    <div class="page-content__html html-content">
				        <?php the_content(); ?>
                    </div>
                </div><!--/.page-content-->

            </article><!--/.single-post-->
        <?php endwhile; ?>
    </main><!--/.site-main-->
</div><!--/.page-wrapper-->
<?php
get_footer();
