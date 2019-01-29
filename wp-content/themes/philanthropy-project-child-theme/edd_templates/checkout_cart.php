<?php
/**
 *  This template is used to display the Checkout page when items are in the cart
 */ 

global $post; 
$charges = pp_get_donor_fees_on_checkout();
$campaign_title = $charges['campaign_title'];
$platform_percent_fee = $charges['platform_percent_fee'];
$stripe_percent_fee = $charges['stripe_percent_fee'];
$enable_donor_covers_fee = $charges['donor-covers-fee'];
$currency_helper = charitable_get_currency_helper();
if ( class_exists( 'Charitable_EDD_Cart' ) ) :
	$cart      = new Charitable_EDD_Cart( edd_get_cart_contents(), edd_get_cart_fees( 'item' ) );
	$campaigns = $cart->get_benefits_by_campaign();
else :
	$campaigns = array();
endif;

if(class_exists('PP_Team_Fundraising')){
	$campaigns = PP_Team_Fundraising::remove_parent_from_campaign_benefits($campaigns);
}

					
					?>


<section class="checkout-block ">
		<div class="container">
			<div class="row">
				<h2 class="checkout_title">CHECKOUT</h2>
				<div class="col-lg-10 form-block">
					<p> You're contributing to:</p></br>
					
					<?php foreach ( $campaigns as $campaign_id => $benefits ) :
					
					$url = "";
					if ( has_post_thumbnail( $campaign_id ) ) :
					$url =  get_the_post_thumbnail_url( $campaign_id, 'reach-post-thumbnail-full' );
					endif;
					endforeach;
					?>
					<a target="_blank" href="<?php echo get_permalink($campaign_id);?>"><h2 class="mb-3 font-weight-bold"><?php echo $campaign_title;?></h2></a>
					<div class="form-image">
					<img src="<?php echo $url;?>" alt="image" class="img-fluid">
					<ul class="amount-detail">
					<?php foreach( edd_get_cart_fees() as $fee_id => $fee ) : ?>
						<li><label for="amount">DONATION AMOUNT:</label> <span class="edd_cart_fee_amount"><?php echo esc_html( edd_currency_filter( edd_format_amount( $fee['amount'] ) ) ); ?></span></li>
					 <?php endforeach;
					
					if($charges['donor-covers-fee'] ):?>
						<li class="covered_fees_tr"><label for="amount">PROCESSING FEES:</label> <span> <?php echo  $currency_helper->get_monetary_amount($charges['total-fee-amount']); ?></span></li>
					<?php 
					endif;
					?>
					<?php 
						if((isset($_POST['donor_selection']) && $_POST['donor_selection'] == "true") || !isset($_POST['donor_selection'])){
						if($charges['donor-covers-fee']  ) {
							$total =  $currency_helper->get_monetary_amount($charges['gross-amount']);
							$data_total = $charges['gross-amount'];
						}else{
							$currency_helper = charitable_get_currency_helper();
							$total = $currency_helper->get_monetary_amount(edd_get_cart_total()); 
							$data_total = edd_get_cart_total(); 
						}}else {
							$currency_helper = charitable_get_currency_helper();
							$total = $currency_helper->get_monetary_amount(edd_get_cart_total()); 
							$data_total = edd_get_cart_total(); 
						}
						?>
					<li class="total-amount"><label for="amount">TOTAL CHARGE:</label> <span class="edd_cart_total"><span class="edd_cart_amount" data-subtotal="<?php echo $data_total; ?>" data-total="<?php echo $data_total; ?>"><?php echo $total; ?></span></span></li>
					<li><label> <p>I'd like to cover the processing fee so that 100% of my donation goes to <?php echo $campaign_title; ?>.</p> </label>

					<span><div id="switch-covers-fee" class="switch-button">
					<input id="donor-covers-fee" type="checkbox" name="charge_data[donor-covers-fee]" value="yes" data-total="<?php echo edd_get_cart_total(); ?>" data-platform-fee="<?php echo $platform_percent_fee; ?>" data-stripe-percent-fee="<?php echo $stripe_percent_fee; ?>" 
					<?php if((isset($_POST['donor_selection']) && $_POST['donor_selection'] == "true") || !isset($_POST['donor_selection'])){
					 checked($enable_donor_covers_fee); }?>>
					
					<label for="donor-covers-fee"></label>
				</div></span></li>
					
					</ul>
					</div>
					
					
					</div>
					
		</div>
		</div>
	</section>
					
					
		
