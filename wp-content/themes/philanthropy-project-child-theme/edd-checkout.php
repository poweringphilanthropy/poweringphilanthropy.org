<?php 
/**
 * Checkout page template.
 *
 * This template is only used if Easy Digital Downloads is active.
 *
 * @package Reach
 */

if ( ! reach_has_edd() ) {
	return;
}

if ( class_exists( 'Charitable_EDD_Cart' ) ) :
	$cart      = new Charitable_EDD_Cart( edd_get_cart_contents(), edd_get_cart_fees( 'item' ) );
	$campaigns = $cart->get_benefits_by_campaign();
else :
	$campaigns = array();
endif;

if(class_exists('PP_Team_Fundraising')){
	$campaigns = PP_Team_Fundraising::remove_parent_from_campaign_benefits($campaigns);
}


get_header( );
$url = get_the_post_thumbnail_url() ;
?>    
<main id="main" class="site-main site-content cf checkout-block" style="background-image:url('<?php echo $url; ?>') !important; ">  
	<div class="layout-wrapper">    
		<div id="primary" class="content-area <?php if ( empty( $campaigns ) ) : ?>no-sidebar<?php endif ?>">      
		<?php

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				get_template_part( 'partials/content', 'page' );

			endwhile;
		endif;

		?>
		</div><!-- #primary -->
	
	</div><!-- .layout-wrapper -->
</main><!-- #main -->
<style>
.layout-wide .layout-wrapper {max-width: 120rem;}
</style>
<?php

get_footer( );
