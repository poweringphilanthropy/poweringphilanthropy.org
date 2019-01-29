<?php
/*
 * Main theme functions 
 * for pp project
 * @lafifastahdziq
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if ( ! class_exists( 'PP_Reach' ) ) :

/**
 * Main PP_Reach Class
 *
 * @class PP_Reach
 * @version 1.0
 */
final class PP_Reach {

    /**
     * @var string
     */
    public $version = '1.0';

    /**
     * @var PP_Reach The single instance of the class
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Main PP_Reach Instance
     *
     * Ensures only one instance of PP_Reach is loaded or can be loaded.
     *
     * @since 1.0
     * @static
     * @return PP_Reach - Main instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * PP_Reach Constructor.
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();

        do_action( 'pp_reach_loaded' );
    }

    /**
     * Hook into actions and filters
     * @since  1.0
     */
    private function init_hooks() {
        
    }

    /**
     * Define PPR Constants
     */
    private function define_constants() {

        $this->define( 'PP_REACH_THEME_FILE', __FILE__ );
        $this->define( 'PP_REACH_THEME_BASENAME', plugin_basename( __FILE__ ) );
        $this->define( 'PP_REACH_VERSION', $this->version );

        /**
         * not sure, but seems it required
         */
        $this->define( 'PHILANTHROPY_PROJECT_CAMPAIGN_ID', 4574 );
    }

    /**
     * Define constant if not already set
     * @param  string $name
     * @param  string|bool $value
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }

    /**
     * What type of request is this?
     * string $type ajax, frontend or admin
     * @return bool
     */
    private function is_request( $type ) {
        switch ( $type ) {
            case 'admin' :
                return is_admin();
            case 'ajax' :
                return defined( 'DOING_AJAX' );
            case 'cron' :
                return defined( 'DOING_CRON' );
            case 'frontend' :
                return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        // all public includes
        include_once( 'inc/functions-pp_reach.php' );
        include_once( 'inc/class-ppr_theme.php' );
        include_once( 'inc/class-ppr_customizer.php' );
        include_once( 'inc/class-ppr_theme_modifications.php' );

        if ( $this->is_request( 'admin' ) ) {
            // include_once( 'inc/admin/..*.php' );
        }

        if ( $this->is_request( 'ajax' ) ) {
            // include_once( 'inc/ajax/..*.php' );
        }

        if ( $this->is_request( 'frontend' ) ) {
            // include_once( 'inc/walker.class.php' );
        }
    }

    /**
     * Get the theme url.
     * @return string
     */
    public function theme_url() {
        return get_stylesheet_directory_uri();
    }

    /**
     * Get the theme path.
     * @return string
     */
    public function theme_path() {
        return get_stylesheet_directory();
    }

    /**
     * Get folder inside theme path
     * @param  string  $type          [description]
     * @param  boolean $url [description]
     * @return [type]                 [description]
     */
    public function get_path( $type = '', $url = false ) {

        $base = $url ? $this->theme_url() : $this->theme_path();
        
        switch ($type) {

            case 'css':
                $path = $base . '/assets/css';
                break;

            case 'js':
                $path = $base . '/assets/js';
                break;
            
            default:
                $path = $base . '/' . $type;
                break;
        }

        return $path;
    }

    /**
     * Get Ajax URL.
     * @return string
     */
    public function ajax_url() {
        return admin_url( 'admin-ajax.php', 'relative' );
    }

}

endif;

/**
 * Returns the main instance of PPR to prevent the need to use globals.
 *
 * @since  1.0
 * @return PP_Reach
 */
function PPR() {
    return PP_Reach::instance();
}

PPR();


add_filter( 'edd_log_test_payment_stats', '__return_true' );

function admin_default_page($redirect_to) {
	$url = parse_url($redirect_to);
	return $url['path'].$url['query'];
}

add_filter('login_redirect', 'admin_default_page');

add_filter('charitable_donation_values' , 'add_shipping');
function add_shipping($data){
	if( edd_cart_has_fees('fee') ) :
		foreach( edd_get_cart_fees('fee') as $fee_id => $fee ) :
			if($fee['type']  == "fee") :
				$donation_array = array();
				$donation_array['campaign_id'] = $_POST['charge_data']['campaign-benefited'];
				$donation_array['amount'] = $fee['amount'];
				$donation_array['campaign_name'] = $fee['label'];
				$data['campaigns'][] = $donation_array;
			endif;
		 endforeach;
	endif;
	return $data;
}


add_action( 'edd_insert_payment', 'create_donation_2', 100 , 2 );
function create_donation_2($payment_id , $data2){
	$donation_id = get_post_meta($payment_id , 'charitable_donation_from_edd_payment' ,true);
	$donation_from_edd_payment_log = get_post_meta($donation_id , 'donation_from_edd_payment_log' , true);
	if( edd_cart_has_fees('fee') ) :
		foreach( edd_get_cart_fees('fee') as $fee_id => $fee ) :
			if($fee['type']  == "fee") :
				$donation_array = array();
				$donation_array['campaign_id'] = $_POST['charge_data']['campaign-benefited'];
				$donation_array['amount'] = $fee['amount'];
				$donation_array['is_shipping'] = true;
				$donation_array['edd_fee'] = false;
				$donation_array['download_id'] = $fee['download_id'];
				$donation_array['price_id'] = $fee['price_id'];
				$donation_array['price'] = $fee['amount'];
				$donation_from_edd_payment_log[] = $donation_array;
			endif;
		 endforeach;
		 
	endif;
	update_post_meta($donation_id , 'donation_from_edd_payment_log' ,$donation_from_edd_payment_log);
}

add_filter('charitable_log_email_send','stop_ending_campaign_emails' , 10 , 2);
function stop_ending_campaign_emails($email_id , $email){
	if($email == "creator_campaign_ending"){
		return false;
	}
}


add_filter('charitable_campaign_dashboard_column_names' , 'add_donation_column');
function add_donation_column($columns){
	$new_columns = array();
	$i=1;
	foreach($columns as $key => $column){
		if($i==6):
			$new_columns['crm'] = __( 'CRM', 'charitable' );
		endif;
		$new_columns[$key] = $column;
		$i++;
	}
	return $new_columns;
}

add_filter('charitable_campaign_column_display' , 'add_donation_column_value' , 10 , 4);
function add_donation_column_value($display, $column_name, $post_id, $campaign){
	if($column_name == 'crm'):
		$display = get_post_meta($post_id,'post_sub_campaign_crm_id' , true);
	endif;
	return $display;
}

add_action( 'save_post', 'save_crm_id_for_campaign', 10, 3 );

function save_crm_id_for_campaign( $post_ID, $post, $update ) {
	if($post->post_type == 'campaign'){
		update_post_meta($post_ID , 'post_sub_campaign_crm_id' , $_POST['crm_id']);
	}
}

add_filter( 'manage_edit-campaign_sortable_columns', 'my_sortable_cake_column' );
function my_sortable_cake_column( $columns ) {
    $columns['end_date'] = 'end_date';
     return $columns;
}

add_action( 'pre_get_posts', 'my_slice_orderby' );
function my_slice_orderby( $query ) {
    if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'end_date' == $orderby ) {
        $query->set('meta_key','_campaign_end_date');
        $query->set('orderby','meta_value');
    }
}

add_action("campaign_group_edit_form_fields", 'add_form_fields_example', 10, 2);

function add_form_fields_example($term, $taxonomy){
	//echo "</pre>";
	$termid = $term->term_id;
	 $toolkitdata  = get_term_meta($termid,'toolkit',true);
	 $sponsorsdata = get_term_meta($termid,'sponsors',true);
//	print_r($taxonomy);
	
    ?>
    <tr valign="top">
        <th scope="row">Toolkits</th>
        <td>
            <?php wp_editor(html_entity_decode($toolkitdata), 'cuztom[description_new]', array('media_buttons' => true)); ?>
            <script>
                jQuery(window).ready(function(){
                    jQuery('label[for=description_new]').parent().parent().remove();
                });
            </script>
        </td>
    </tr>
	
	<tr valign="top">
        <th scope="row">Sponsors</th>
        <td>
            <?php wp_editor(html_entity_decode($sponsorsdata), 'cuztom[sponsors]', array('media_buttons' => true)); ?>
            <script>
                jQuery(window).ready(function(){
                    jQuery('label[for=sponsors]').parent().parent().remove();
                });
            </script>
        </td>
    </tr>
    <?php
}
function my_style_sheets() {
	//site_url();
	
    wp_enqueue_style( 'style css', get_template_directory_uri().'/style.css' );
   // wp_enqueue_style( 'checkout css', get_template_directory_uri().'/checkout.css',array( 'style' ) );
  //  wp_enqueue_style( 'bootstrap css', get_template_directory_uri().'/bootstrap.min.css' ,array( 'style' ) );
	wp_enqueue_style('child-style', get_stylesheet_uri());
}
add_action( 'wp_enqueue_scripts', 'my_style_sheets' ); 

add_action( 'wp_head', 'header_css' ); 

function header_css(){
	
	?>
	<link rel='stylesheet' id='child-checkout-css'  href='https://www.givemyday.com/wp-content/themes/philanthropy-project-child-theme/checkout.css' type='text/css' media='all' />
	
	<link rel='stylesheet' id='child-style-css'  href='https://www.givemyday.com/wp-content/themes/philanthropy-project-child-theme/bootstrap.min.css' type='text/css' media='all' />
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"> 
<?php }


add_action( 'widgets_init', 'right_sidebar_widget' );

function right_sidebar_widget() {
    register_sidebar( array(
        'name' => 'Left Supporter Siderbar',
        'id' => 'supporter-siderbar',
        'description' => 'Supporter Sidebar',
        'before_widget' => '<aside id="charitable_donors_widget-3" class="widget cf widget_charitable_donors_widget">',
        'after_widget' => '</aside>',
        'before_title' => '<div class="title-wrapper"><h4 class="widget-title">',
        'after_title' => '</h4></div>',
    ) );
}

add_filter('edd_email_heading' , 'remove_p_margin');
function remove_p_margin($heading){
	return strip_tags(str_replace('</p>', ' ', $heading));
}
add_filter('charitable_donor_comment_data' , 'donor_name_from_checkout');
function donor_name_from_checkout($data){
	if(isset($_POST['display']) && $_POST['display'] == "other"){
		$data['comment_author'] = $_POST['other_name'];
	}
	return $data;
}

add_action( 'wp_ajax_load_more_donors', 'load_more_donors' );
add_action( 'wp_ajax_nopriv_load_more_donors', 'load_more_donors' );
function load_more_donors(){
	$campaign_id = $_POST['campaign_id'];
	$paged = $_POST['paged'];
	$instance = array(
				'output'          => 'donors',
				'status'          => array( 'charitable-completed', 'charitable-preapproved' ),
				'orderby'         => 'recent',
				'order'           => 'DESC',
				'number'          => 20,
				'paged'           => 1,
				'fields'          => 'all',
				'campaign'        => 'current',
				'distinct_donors' => true,
				'donor_id'        => 0,
				'include_erased'  => 1,
				'date_query'      => array(),
				'meta_query'      => array(),
			);
	$defaults = apply_filters( 'charitable_donors_widget_default_args', array(
				'title'         	=> '',
				'number'        	=> 10,
				'order'         	=> 'recent',
				'campaign_id'   	=> $campaign_id,
				'show_distinct' 	=> 1,
				'show_avatar' 		=> 1,
				'show_location' 	=> 0,
				'show_amount'   	=> 1,
				'show_name'     	=> 1,
				'hide_if_no_donors' => 0,
			), $instance );

			 
	$instance              = wp_parse_args( $instance, $defaults );
	$view_args             = array_merge( $args, $instance );
	$view_args['campaign'] = $campaign_id;
	$view_args['orderby']  = 'recent';
	$view_args['order']    = 'DESC';

	$query_args = array(
				'output'          => 'donors',
				'status'          => array( 'charitable-completed', 'charitable-preapproved' ),
				'orderby'         => 'date',
				'order'           => 'DESC',
				'number'          => 10,
				'paged'           => $paged,
				'fields'          => 'all',
				'campaign'        => array($campaign_id),
				'distinct_donors' => false, 
				'donor_id'        => 0,
				'include_erased'  => 1,
				'date_query'      => array(),
				'meta_query'      => array(),
			);
	$view_args['donors']   = new Charitable_Donor_Query( $query_args );
	$record_found = $view_args['donors']->count();
	$load_more = false;
	if($record_found == 10){
		$load_more = true;
	}
	$paged++;
	ob_start();
	charitable_template( 'widgets/load_donors.php', $view_args );
	$output = ob_get_contents();
	ob_end_clean();
	
	echo  json_encode(array('status' => true, 'html' => $output , 'paged' => $paged , 'load_more' => $load_more));
	die();
	
}