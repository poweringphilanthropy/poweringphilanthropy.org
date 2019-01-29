<?php
/**
 * Template name: Thanks Page
 *
 * @package Reach
 */

get_header();
	$url = get_the_post_thumbnail_url() ;
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
						
			get_template_part( 'partials/banner' ); 
			?>
			<div class="">
				<main class="site-main content-area thanks-page checkout-block" role="main" style="background-image:url('<?php echo $url; ?>'); width: 100%;padding: 0 71px; ">
					<?php get_template_part( 'partials/content', 'page' ) ?>
				</main><!-- .site-main -->
				<?php get_sidebar() ?>
			</div><!-- .layout-wrapper -->
		<?php 
		endwhile;
	endif;

get_footer();