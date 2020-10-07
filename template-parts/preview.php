<?php
$img = get_the_post_thumbnail_url(get_the_ID(), 'medium');
$title = get_the_title();
$excerpt = theme_get_the_excerpt(15);
$link = get_the_permalink();
?>
<div <?php post_class('card post-preview'); ?> id="post-<?php the_ID(); ?>">
    <img src="<?= $img ?>" class="card-img-top" alt="<?= $title ?>">
    <div class="card-body">
        <h4 class="card-title"><?= $title ?></h4>
        <p class="card-text"><?= $excerpt ?></p>
        <a href="<?= $link ?>" class="btn btn-primary">Читать</a>
    </div>
</div>