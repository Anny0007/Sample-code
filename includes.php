<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       ankurvishwakarma54@yahoo.com
 * @since      1.0.0
 *
 * @package    Avcl_Wp_Buy_Tickets
 * @subpackage Avcl_Wp_Buy_Tickets/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Avcl_Wp_Buy_Tickets
 * @subpackage Avcl_Wp_Buy_Tickets/includes
 * @author     Ankur Vishwakarma <ankurvishwakarma54@yahoo.com>
 */
class Avcl_Wp_Buy_Tickets {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Avcl_Wp_Buy_Tickets_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		if ( defined( 'AVCL_WP_BUY_TICKETS_VERSION' ) ) {
			$this->version = AVCL_WP_BUY_TICKETS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'avcl-wp-buy-tickets';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Avcl_Wp_Buy_Tickets_Loader. Orchestrates the hooks of the plugin.
	 * - Avcl_Wp_Buy_Tickets_i18n. Defines internationalization functionality.
	 * - Avcl_Wp_Buy_Tickets_Admin. Defines all hooks for the admin area.
	 * - Avcl_Wp_Buy_Tickets_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-avcl-wp-buy-tickets-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-avcl-wp-buy-tickets-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-avcl-wp-buy-tickets-meta-boxes.php';
	   
	    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'functions.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-avcl-wp-buy-tickets-admin.php';
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-avclwpc-throw-messages.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-avcl-wp-buy-tickets-public.php';



		$this->loader = new Avcl_Wp_Buy_Tickets_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Avcl_Wp_Buy_Tickets_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Avcl_Wp_Buy_Tickets_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Avcl_Wp_Buy_Tickets_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_events_post_type' ); //Register custom post type
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_builder_menu' );
		$this->loader->add_action( 'wp_ajax_avclwpc_do_builder_duplicate', $plugin_admin, 'avclwpc_do_builder_duplicate' );
		$this->loader->add_action( 'wp_ajax_avclwpc_product_page_display_event_setup', $plugin_admin, 'avclwpc_product_page_display_event_setup' );
		$this->loader->add_action( 'wp_ajax_avclwpc_delete_builder', $plugin_admin, 'avclwpc_delete_builder' );
		$this->loader->add_action( 'init', $plugin_admin, 'avclwpc_save_theater_data' );
		$this->loader->add_action( 'init', $plugin_admin, 'avclwpc_save_theater_settings' );
		$this->loader->add_action( 'avclwcb_before_builder_generator', $plugin_admin, 'avclwpc_theater_form' );
		$this->loader->add_action( 'avclwcb_add_builder_page', $plugin_admin, 'avclwpc_main_page_html' );
		$this->loader->add_action( 'avclwcb_new_form', $plugin_admin, 'avclwpc_generate_new_form' );
		$this->loader->add_filter( 'product_type_selector', $plugin_admin, 'avclwpc_add_product_type_in_wc' );
		$this->loader->add_filter( 'woocommerce_product_data_tabs', $plugin_admin, 'avclwpc_show_product_tab' );
	 	$this->loader->add_filter( 'woocommerce_product_class', $plugin_admin, 'avclwpc_load_cinematic_class',99,2 );
		$this->loader->add_action( 'woocommerce_product_data_panels', $plugin_admin, 'avclwpc_cinematic_product_type_content' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'avclwpc_save_cinematic_product_type_content' );
	    $this->loader->add_action( 'woocommerce_order_status_changed', $plugin_admin, 'avclwpc_when_order_status_changed',10,4 );
		$this->loader->add_action( 'init', $plugin_admin, 'avclwpc_know_woo_currency_set_status' );
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Avcl_Wp_Buy_Tickets_Public( $this->get_plugin_name(), $this->get_version() );
	
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp', $plugin_public, 'initialize_parameters_and_functions' );
		$this->loader->add_filter( 'woocommerce_is_sold_individually', $plugin_public, 'avclwpc_remove_quantity_btn',10,2 );
		$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public, 'avclwpc_show_data_in_front' );
		$this->loader->add_action( 'wp_footer', $plugin_public, 'avclwpc_inject_seat_layout');
		$this->loader->add_action( 'wp_ajax_avclwpc_search_theater_by_date', $plugin_public, 'avclwpc_search_theater_by_date' );
		$this->loader->add_action( 'wp_ajax_nopriv_avclwpc_search_theater_by_date', $plugin_public, 'avclwpc_search_theater_by_date' );
		$this->loader->add_action( 'wp_ajax_avclwpc_change_show', $plugin_public, 'avclwpc_change_show' );
		$this->loader->add_action( 'wp_ajax_nopriv_avclwpc_change_show', $plugin_public, 'avclwpc_change_show' );
		$this->loader->add_action( 'wp_ajax_avclwpc_add_to_cart', $plugin_public, 'avclwpc_add_to_cart' );
		$this->loader->add_action( 'wp_ajax_nopriv_avclwpc_add_to_cart', $plugin_public, 'avclwpc_add_to_cart' );
		/*remove price in shop page*/
		$this->loader->add_filter( 'woocommerce_variable_sale_price_html', 'avclwpc_remove_prices_in_shop_page', 9999, 2 );
 		$this->loader->add_filter( 'woocommerce_variable_price_html',$plugin_public, 'avclwpc_remove_prices_in_shop_page', 9999, 2 );
 		$this->loader->add_filter( 'woocommerce_get_price_html', $plugin_public,'avclwpc_remove_prices_in_shop_page', 9999, 2 );
 		/*end*/
 		$this->loader->add_filter( 'woocommerce_cart_item_name', $plugin_public, 'avclwpc_add_booked_seats_to_cart', 10, 3 );
		$this->loader->add_filter( 'woocommerce_checkout_cart_item_quantity', $plugin_public, 'avclwpc_add_booked_seats_to_checkout', 10, 3 );
		$this->loader->add_filter( 'woocommerce_add_cart_item_data', $plugin_public,'avclwpc_add_booked_seat_session_in_woocommerce_session',1,2);
 		$this->loader->add_filter( 'woocommerce_get_cart_item_from_session', $plugin_public, 'avclwpc_get_cart_items_from_session', 1, 3 );
 		$this->loader->add_action( 'woocommerce_checkout_create_order_line_item', $plugin_public,'avclwpc_add_seats_data_in_order_meta',10,4);
 		$this->loader->add_action( 'woocommerce_before_cart_item_quantity_zero', $plugin_public,'avclwpc_remove_booked_seat_details_when_product_remove_from_cart',1,1);
		$this->loader->add_action( 'woocommerce_before_order_itemmeta', $plugin_public, 'avclwpc_display_order_item_meta_in_order_details_page',10,3);
		$this->loader->add_action( 'woocommerce_order_item_meta_start', $plugin_public, 'avclwpc_display_seat_details_in_thankyou_page',10,3);
		$this->loader->add_action( 'woocommerce_before_checkout_form', $plugin_public, 'avclwpc_checkout_btn_pressed_in_cart_page');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Avcl_Wp_Buy_Tickets_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
