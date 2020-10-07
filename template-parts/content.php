<?php
/**
 * Template to display generic post content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('page-entry'); ?>>

    <div class="page-header container">
        <h1 class="page-title"><?= get_the_title(); ?></h1>
    </div><!--/.page-header -->

    <div class="page-content container">

		<?php if ($img = get_the_post_thumbnail_url(get_the_ID(), 'full')) : ?>
            <div class="page-content__img-block text-center">
                <img src="<?= $img ?>" alt="<?= get_the_title(); ?>" class="page-content__main-img">
            </div>
		<?php endif; ?>

        <div class="page-content__html html-content">
			<?php the_content(); ?>
        </div>

    </div><!--/.page-content-->

</article><!--/.single-post-->
