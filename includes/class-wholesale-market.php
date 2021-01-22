<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/includes
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
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/includes
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Wholesale_Market
{

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wholesale_Market_Loader    $loader    Maintains and registers all hooks for the plugin.
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
	public function __construct()
	{
		if (defined('WHOLESALE_MARKET_VERSION')) {
			$this->version = WHOLESALE_MARKET_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wholesale-market';

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
	 * - Wholesale_Market_Loader. Orchestrates the hooks of the plugin.
	 * - Wholesale_Market_i18n. Defines internationalization functionality.
	 * - Wholesale_Market_Admin. Defines all hooks for the admin area.
	 * - Wholesale_Market_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies()
	{

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wholesale-market-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wholesale-market-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wholesale-market-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wholesale-market-public.php';

		$this->loader = new Wholesale_Market_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wholesale_Market_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale()
	{

		$plugin_i18n = new Wholesale_Market_i18n();

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks()
	{

		$plugin_admin = new Wholesale_Market_Admin($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');

		// Adding Setting Tab Having a Name With Wholesale 
		$this->loader->add_filter('woocommerce_settings_tabs_array', $plugin_admin, 'ced_add_settings_tab_wholesale_market', 50);
		$this->loader->add_action('woocommerce_sections_wholesale', $plugin_admin, 'output_sections');
		$this->loader->add_action('woocommerce_settings_wholesale', $plugin_admin, 'output');
		$this->loader->add_action('woocommerce_settings_save_wholesale', $plugin_admin, 'save');
		//Adding Fields to For Variation products
		$this->loader->add_action('woocommerce_variation_options_pricing', $plugin_admin, 'ced_product_edit_page_wholesale_setting_variation_fields', 10, 3);
		$this->loader->add_action('woocommerce_save_product_variation', $plugin_admin, 'ced_save_product_edit_page_wholesale_setting_variation_fields', 10, 2);
		//Adding Fields to For Simple products
		$this->loader->add_action('woocommerce_product_options_pricing', $plugin_admin, 'ced_product_edit_page_wholesale_setting_simple_product_fields');
		$this->loader->add_action('woocommerce_process_product_meta', $plugin_admin, 'ced_save_product_edit_page_wholesale_setting_simple_product_fields');
		//Adding Custom Column in User Table Having a Name With 'WholeSale Customer'
		$this->loader->add_action('manage_users_columns', $plugin_admin, 'ced_modify_user_columns');
		//Adding Approve Button Where User Will Requested to become WholeSale customer
		$this->loader->add_action('manage_users_custom_column', $plugin_admin, 'ced_user_posts_count_column_content', 10, 3);
		//Adding New Role WholeSale Customer 
		$this->loader->add_action('admin_init', $plugin_admin, 'ced_add_wholesale_role');
	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks()
	{

		$plugin_public = new Wholesale_Market_Public($this->get_plugin_name(), $this->get_version());

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		//Adding a chekbox for Wholesale Customer if user wants to become
		$this->loader->add_action('woocommerce_register_form', $plugin_public, 'ced__add_wholesale_customer_request_field_registration_form');
		//Saving a Value if Checkbox is checked
		$this->loader->add_action('woocommerce_created_customer', $plugin_public, 'ced_add_user_request_for_wholesale_customer');
		$this->loader->add_action('woocommerce_after_shop_loop_item_title', $plugin_public, 'ced_show_wholesale_price');
		$this->loader->add_action('woocommerce_single_product_summary', $plugin_public, 'ced_show_wholesale_price');
		$this->loader->add_filter( 'woocommerce_available_variation',$plugin_public, 'ced_show_wholesale_variable_price_single_Page', 10, 3 );
		$this->loader->add_action('woocommerce_before_calculate_totals',$plugin_public,'ced_recalculate_price_wholesale');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wholesale_Market_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}
}
