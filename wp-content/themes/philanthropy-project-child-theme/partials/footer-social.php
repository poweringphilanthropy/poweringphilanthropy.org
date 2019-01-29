<div class="layout-wrapper">
	<div class="uk-grid">
		<div class="uk-width-1-1 uk-width-medium-1-2 join-email-list left-content">
			<span class="big-text"><?php _e('Join our email list:', 'pp-theme'); ?></h3>
		</div>
		<div class="uk-width-1-1 uk-width-medium-1-2 right-content"></div>
	</div>
	<div class="uk-grid grid-email-list">
		<div class="uk-width-1-1 uk-width-medium-1-2 join-email-list left-content">
		<?php echo do_shortcode('[mc4wp_form id="603"]');?>
		</div>
		<div class="uk-width-1-1 uk-width-medium-1-6 " style="width:10.666%;"></div>
		<div class="uk-width-1-1 uk-width-medium-1-3 right-content">
			<span class="big-text follow-us-text">Follow US:</span>
			<ul class="social-link">
				<li><a href="https://www.facebook.com/GiveMyDay/"><img src="<?php echo PPR()->get_path('media', true); ?>/facebook.png" class="icon" alt="facebook"></a></li>
				
				<li><a href="https://www.instagram.com/givemyday"><img src="<?php echo PPR()->get_path('media', true); ?>/instagram.png" class="icon" alt="instagram"></a></li>
				
				
			</ul>
		</div>
	</div>
</div>