<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/public
 * @author     Cedcommerce <rajivranjanshrivastav@cedcoss.com>
 */
class Wholesale_Market_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_Market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_Market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wholesale-market-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wholesale_Market_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wholesale_Market_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wholesale-market-public.js', array('jquery'), $this->version, false);
	}


	/**
	 * Function:ced__add_wholesale_customer_request_field_registration_form
	 * Description:Add a Checkbox to Select Whether User Want to Become Wholesale User Or Not
	 * Version :1.0.0
	 * @since  1.0.0
	 * @return void
	 */
	public function ced__add_wholesale_customer_request_field_registration_form()
	{
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			woocommerce_form_field(
				'wholesale_customer_request',
				array(
					'type'        => 'checkbox',
					'label'       => 'Become WholeSale Customer'
				),
			);
		}
	}
	
	/**
	 * Function :ced_add_user_request_for_wholesale_customer
	 * Description:Saving a Checkbox value  Whether User Want to Become Wholesale User Or Not
	 * Version :1.0.0
	 * @since  1.0.0
	 * @param  mixed $customer_id
	 * @return void
	 */
	public function ced_add_user_request_for_wholesale_customer($customer_id)
	{
		if ( isset( $_POST['wholesale_customer_request'] ) ) {
			update_user_meta( $customer_id, 'wholesale_customer_request', wc_clean('requested') );
		}
	}
}
