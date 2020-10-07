<?php
// Last news section with previews
?>
<?php
$news_query = new WP_Query( array(
	'post_type' => 'post',
	'category_name' => 'news',
	'orderby' => 'date',
	'order' => 'DESC',
	'posts_per_page' => 4,
) );

if ($news_query->have_posts() ) :
	?>
	<section class="news-block">
		<div class="container">
			<div class="news-block__header">
				<h2 class="news-block__title">Новости</h2>
			</div>
			<div class="row news-block__list">
				<?php  while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
					<div class="col-sm-6 mb-3">
						<?php get_template_part( 'template-parts/preview', 'news' ); ?>
					</div>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div><!--/.row-->
		</div>
	</section><!--/.news-block-->
<?php endif; ?>
