<?php
/**
 * Campaign content block.
 *
 * This template is only used if Charitable is active.
 *
 * @package Reach
 */

if ( ! reach_has_charitable() ) :
	return;
endif;

?>
<article id="campaign-<?php echo get_the_ID() ?>" <?php post_class( 'campaign-content' ) ?>>
	<div class="block entry-block">
		<div class="entry">
			<h2><?php _e( 'About My Cause:', 'reach' ) ?></h2>
			<?php 
			$campaign = charitable_get_current_campaign();
			reach_template_campaign_media_before_content($campaign); ?>
			<?php the_content() ?>
		</div>
	</div>
</article>