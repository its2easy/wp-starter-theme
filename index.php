<?php
get_header();
?>
<div class="page-wrapper">
    <main class="site-main container">

    <?php
    if ( have_posts() ) :

        if ( is_home() && ! is_front_page() ) :
            ?>
            <header>
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        while ( have_posts() ) : the_post();
            get_template_part( 'template-parts/preview', get_post_type() );
        endwhile;
        theme_the_pagination();

    else :
        get_template_part( 'template-parts/content', 'none' );
    endif;
    ?>

    </main><!--/.site-main.container-->
</div><!--/.page-wrapper-->
<?php
get_sidebar();
get_footer();
