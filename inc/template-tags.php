<?php

/**
 * Theme pagination
 *
 * @param null|bool $echo if true output markup, if false returns
 * @param null|array $fake {
 *      Fake parameters to test
 *      @type int $current Current page number
 *      @type int $total Total pages
 *
 * @return string Html markup
 * }
 */
function theme_the_pagination($echo = true, $fake = null){
	global $wp_query;
	if ( $fake || $wp_query->max_num_pages > 1 ) {
		?>
        <nav class="theme-pagination">
			<?php
			$pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
				'base'      => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
				'format'    => '',
				'add_args'  => false,
				'current'   => ($fake) ? $fake['current'] : max( 1, get_query_var( 'paged' ) ),
				'total'     => ($fake) ? $fake['total'] : $wp_query->max_num_pages,
				'prev_next' => true,
				'prev_text' => get_inline_svg('arrow-left', false) . "<span>Назад</span>",
				'next_text' => "<span>Вперёд</span>" . get_inline_svg('arrow-left', false),
				'type'      => 'list',
				'end_size'  => 1,
				'mid_size'  => 1,
			) ) );
			//$pagination = str_replace(
			//        '<span class="page-numbers dots">&hellip;</span>',
            //        '<div class="aorion-pagination__dots"></div>',
            //        $pagination);
			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
			?>
        </nav>
		<?php
	}
}

/**
 * Theme breadcrumbs
 */
function theme_the_breadcrumbs(){
	?>
    <nav class="custom-breadcrumbs">
        <div class="container">
            <div class="custom-breadcrumbs__list" typeof="BreadcrumbList" vocab="https://schema.org/">
				<?php if(function_exists('bcn_display')) { bcn_display(); }?>
            </div>
        </div>
    </nav>
	<?php
}


