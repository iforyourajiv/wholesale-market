<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cedcommerce.com/
 * @since      1.0.0
 *
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wholesale_Market
 * @subpackage Wholesale_Market/admin
 *
 */
class Wholesale_Market_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wholesale-market-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wholesale-market-admin.js', array('jquery'), $this->version, false);
	}


	/**
	 * Function:ced_add_settings_tab_wholesale_market
	 * Description : Adding Custom Setting Tab "WholeSale Market " in Woocommerce Setting 
	 * Version :1.0.0
	 *
	 * @since    1.0.0
	 * @param  mixed $settings_tabs
	 * @return $settings_tabs
	 */
	public static function ced_add_settings_tab_wholesale_market( $settings_tabs) {
		$settings_tabs['wholesale'] = __('WholeSale Market', 'wholesale-market');
		return $settings_tabs;
	}

	/**
	 * Funcion :get_sections
	 * Version :1.0.0
	 * Description : Creating New Sections
	 *
	 * @since  1.0.0
	 * @return $sections with custom hook
	 */
	public function get_sections() {
		$sections = array(
			'' => __('General', 'wholesale-market'),
			'inventory' => __('Inventory', 'wholesale-market')
		);

		return apply_filters('woocommerce_get_sections_wholesale-market', $sections);
	}

	/**
	 * Funcion :output_sections
	 * Version :1.0.0
	 * Description : Displaying Sections for Wholesale Tab
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function output_sections() {

		global $current_section;
		$sections = $this->get_sections();
		if (empty($sections) || 1 === count($sections)) {
			return;
		}
		echo '<ul class="subsubsub">';
		$array_keys = array_keys($sections);
		foreach ($sections as $id => $label) {
			echo '<li><a href="' . esc_html(admin_url('admin.php?page=wc-settings&tab=wholesale&section=' . sanitize_title($id))) . '" class="' . ( $current_section == $id ? 'current' : '' ) . '">' . esc_html($label) . '</a> ' . ( end($array_keys) == $id ? '' : '|' ) . ' </li>';
		}
		echo '</ul><br class="clear" />';
	}


	/**
	 * Function: get_settings
	 * Version :1.0.0
	 * Description : Creating Forms For Individual Sections
	 *
	 * @since  1.0.0
	 * @return $settings
	 */
	public function get_settings() {
		global $current_section;
		$settings = array();
		if ('' == $current_section) {

			$settings = array(
				array(
					'title' => __('General Setting', 'wholesale-market'),
					'type' => 'title',
					'desc' =>  __('Manage your General settings for the WholeSale Market', 'wholesale-market'),
					'id' => 'wholesale_market_general_settings'
				),
				array(
					'title' => __('Enable/Disable', 'wholesale-market'),
					'type' => 'checkbox',
					'desc' => __('Enable or Disable Wholesale Setting', 'wholesale-market'),
					'id' => 'wholesale_market_checkbox_general',

				),
				array(
					'title'    => __('Show Wholesale Price', 'wholesale-market'),
					'id'       => 'wholesale_market_prices_show_user_type',
					'default'  => 'all_customer',
					'type'     => 'radio',
					'desc_tip' => __('This option is important as it will affect how you Show Wholesale price to user.', 'wholesale-market'),
					'options'  => array(
						'all_customer' => __('Show Wholesale Price to All Customers ', 'wholesale-market'),
						'only_wholesale_customer'  => __('Show Wholesale Price to Only WholeSale Customers', 'wholesale-market'),
					),
				),
				array(
					'title'       => __('Wholesale_price_display', 'wholesale-market'),
					'id'          => 'Wholesale_price_display',
					'default'     => '',
					'placeholder' => __('N/A', 'wholesale-market'),
					'type'        => 'text',
					'desc_tip'    => __('Text Field to store what text should be shown with Wholesale Price.', 'wholesale-market'),
				),
				array(
					'type' => 'sectionend',
					'id' => 'wholesale_market_checkbox_settings'
				),
			);
		} else {
			$settings = array(
				array(
					'title' => __('Inventory Setting', 'wholesale-market'),
					'type' => 'title',
					'desc' =>  __('Manage your Inventory settings for the WholeSale Market', 'wholesale-market'),
					'id' => 'wholesale_market_inventory_settings'
				),
				array(
					'title' => __('Enable minimum Qunatity Setting', 'wholesale-market'),
					'type' => 'checkbox',
					'desc' => __('Enable minimum Qunatity setting for applying wholesale price', 'wholesale-market'),
					'id' => 'wholesale_market_checkbox_inventory_setting',

				),
				array(
					'title'    => __('Set Minimum Quantity', 'wholesale-market'),
					'id'       => 'wholesale_market_prices_show_user',
					'default'  => 'set_product_level_quantity',
					'type'     => 'radio',
					'desc_tip' => __('This option is important as it will affect Radio button for Set Min qty on product level / Set common min qty for all .', 'wholesale-market'),
					'options'  => array(
						'set_product_level_quantity' => __('Set Minimum quantity on product level', 'wholesale-market'),
						'set_common_quantity'  => __('Set common minimum quantity for all', 'wholesale-market'),
					),
				),
				array(
					'title'       => __('Wholesale_minimum_quantity', 'wholesale-market'),
					'id'          => 'Wholesale_minimum_quantity_all',
					'default'     => '',
					'placeholder' => __('Minimum Qunatity for All', 'wholesale-market'),
					'type'        => 'number',
					'wrapper_class' => 'form-row form-row-last',
					'custom_attributes' => array(
						'min'  => 1,
						'required' => 'required'
					),
					'desc_tip'    => __('Text Field to store Minimum Qunatity for all product.', 'wholesale-market'),
				),

				array(
					'type' => 'sectionend',
					'id' => 'wholesale_market_checkbox_settings'
				),
			);
		}
		return apply_filters('woocommerce_get_settings_wholesale-market', $settings);
	}
	/**
	 * Function: output
	 * Version :1.0.0
	 * Description : Preparing Form For Sections
	 *
	 * @since  1.0.0
	 * @return void
	 * 
	 */
	public function output() {
		$settings = $this->get_settings();
		WC_Admin_Settings::output_fields($settings);
	}
	/**
	 * Function: save
	 * Version :1.0.0
	 * Description : Saving Form and fields for sections
	 *
	 * @since  1.0.0
	 * @return void
	 * 
	 */
	public function save() {

		global $current_section;

		$settings = $this->get_settings();

		WC_Admin_Settings::save_fields($settings);

		if ($current_section) {
			do_action('woocommerce_update_options_wholesale_' . $current_section);
		}
	}



	/**
	 * Function :ced_product_edit_page_wholesale_setting_variation
	 * Version :1.0.0
	 * Description : Creating Wholesale Price and Minimum Quantity field for Variation Product on Product edit Page
	 *
	 * @since  1.0.0
	 * @return void
	 * 
	 */
	public function ced_product_edit_page_wholesale_setting_variation_fields( $loop, $variation_data, $variation) {

		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			$label = sprintf(
				/* translators: %s: currency symbol */
				__('WholeSale Price (%s)', 'wholesale-market'),
				get_woocommerce_currency_symbol()
			);
			woocommerce_wp_text_input(array(
				'id' => 'wholesale_variation_price[' . $loop . ']',
				'label' => $label,
				'type' => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'required' => 'required'
				),
				'value' => get_post_meta($variation->ID, 'wholesale_variation_price', true),
				'wrapper_class' => 'form-row form-row-first',
			));

			woocommerce_wp_text_input(array(
				'id' => 'wholesale_variation_nonce',
				'type' => 'hidden',
				'label' => '',
				'value' => wp_create_nonce('variable_product'),
			));
			woocommerce_wp_text_input(array(
				'id' => 'wholesale_variation_min_qty[' . $loop . ']',
				'type' => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'required' => 'required'
				),
				'label' => 'Minimum Quantity',
				'value' => get_post_meta($variation->ID, 'wholesale_variation_min_qty', true),
				'wrapper_class' => 'form-row form-row-last',
			));
		}
	}

	/**
	 * Function :ced_save_product_edit_page_wholesale_setting_variation_fields
	 * Version :1.0.0
	 * Description : Saving Wholesale Price and Minimum Quantity field Value for Variation Product on Product edit Page
	 *
	 * @param  mixed $variation_id
	 * @param  mixed $i
	 * @var $wholesale_price
	 * @var $wholesale_min_qty
	 * @return void
	 */
	public function ced_save_product_edit_page_wholesale_setting_variation_fields( $variation_id, $i) {
		$nonce = isset($_REQUEST['wholesale_variation_nonce']) ? sanitize_text_field($_REQUEST['wholesale_variation_nonce']) : false;
		if (wp_verify_nonce($nonce, 'variable_product')) {
			$wholesale_price   = isset($_POST['wholesale_variation_price'][$i]) ? sanitize_text_field($_POST['wholesale_variation_price'][$i]) : false;
			$wholesale_min_qty = isset($_POST['wholesale_variation_min_qty'][$i]) ? sanitize_text_field($_POST['wholesale_variation_min_qty'][$i]) : false;
			if (isset($wholesale_price)) {
				update_post_meta($variation_id, 'wholesale_variation_price', esc_attr($wholesale_price));
			}
			if (isset($wholesale_min_qty)) {
				update_post_meta($variation_id, 'wholesale_variation_min_qty', esc_attr($wholesale_min_qty));
			}
		}
	}

	/**
	 * Function :ced_product_edit_page_wholesale_setting_simple_product_fields
	 * Version :1.0.0
	 * Description : Creating Wholesale Price and Minimum Quantity field for Simple Product on Product edit Page
	 *
	 * @since  1.0.0
	 * @return void
	 * 
	 */
	public function ced_product_edit_page_wholesale_setting_simple_product_fields() {

		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			$label = sprintf(
				/* translators: %s: currency symbol */
				__('WholeSale Price (%s)', 'wholesale-market'),
				get_woocommerce_currency_symbol()
			);
			woocommerce_wp_text_input(array(
				'id' => 'wholesale_simple_product_price',
				'type' => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'required' => 'required'
				),

				'label' => $label,
				'value' => get_post_meta(get_the_ID(), 'wholesale_simple_product_price', true),

			));
			woocommerce_wp_text_input(array(
				'id' => 'wholesale_simple_product_noonce',
				'label' => '',
				'type' => 'hidden',
				'value' => wp_create_nonce('simple_product')

			));

			woocommerce_wp_text_input(array(
				'id' => 'wholesale_simple_product_min_qty',
				'type' => 'number',
				'custom_attributes' => array(
					'min'  => 1,
					'required' => 'required'
				),
				'label' => 'Minimum Quantity',
				'value' =>  get_post_meta(get_the_ID(), 'wholesale_simple_product_min_qty', true),
			));
		}
	}


	/**
	 * Function :ced_save_product_edit_page_wholesale_setting_simple_product_fields
	 * Version :1.0.0
	 * Description : Saving Wholesale Price and Minimum Quantity field Value for Simple Product on Product edit Page
	 *
	 * @since  1.0.0
	 * @param  mixed $post_id
	 * @var $wholesale_price_simple_product
	 * @var $wholesale_min_qty_simplt_product
	 * @return void
	 */
	public function ced_save_product_edit_page_wholesale_setting_simple_product_fields( $post_id) {
		$nonce = isset($_REQUEST['wholesale_simple_product_noonce']) ? sanitize_text_field($_REQUEST['wholesale_simple_product_noonce']) : false;
		if (wp_verify_nonce($nonce, 'simple_product')) {
			$wholesale_price_simple_product   = isset($_POST['wholesale_simple_product_price']) ? sanitize_text_field($_POST['wholesale_simple_product_price']) : false;
			$wholesale_min_qty_simple_product = isset($_POST['wholesale_simple_product_min_qty']) ? sanitize_text_field($_POST['wholesale_simple_product_min_qty']) : false;
			if (!empty($wholesale_price_simple_product)) {
				update_post_meta($post_id, 'wholesale_simple_product_price', esc_attr($wholesale_price_simple_product));
			}
			if (!empty($wholesale_min_qty_simple_product)) {
				update_post_meta($post_id, 'wholesale_simple_product_min_qty', esc_attr($wholesale_min_qty_simple_product));
			}
		}
	}



	/**
	 *Function: ced_modify_user_columns
	 * Description : Adding Custom Column in User Table Having a name "WholeSale Customer"
	 * Version:1.0.0
	 *
	 * @since  1.0.0
	 * @param  mixed $column_headers
	 * @return $column_headers
	 */
	public function ced_modify_user_columns( $column_headers) {
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			$column_headers['wholesale_customer'] = 'WholeSale Customer';
		}
		return $column_headers;
	}

	/**
	 *Function: ced_modify_user_columns
	 * Description : Adding a "Approve" Button Custom Column in User Table Having a name "WholeSale Customer"
	 * 				 If User has been applied for Wholesale customer
	 * Version:1.0.0
	 *
	 * @since  1.0.0
	 * @param  mixed $column_name
	 * @param  mixed $value
	 * @param  mixed $user_id
	 * @return $column_headers
	 */
	public function ced_user_posts_count_column_content( $value, $column_name, $user_id) {
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			if ('wholesale_customer' == $column_name) {
				$get_status_wholesale_customer = get_user_meta($user_id, 'wholesale_customer_request', true);
				if ('requested' == $get_status_wholesale_customer) {
					$html = "<form action='' method='post'>
						<input type='hidden' name='user_id' id='user_id'  value='" . $user_id . "'>
						<input type='submit' name='approve' id='approve' class='button action' value='Approve'>
							</form>";

					return $html;
				}else {
					$get_status_wholesale_customer = get_user_meta($user_id, 'wholesale_customer_request', true);
					$user = new WP_User($user_id);
					if('wholesale_customer'==$user->roles[0]){
						$html = "<input type='button' id='approved' class='button action' value='Approved'>";
						return $html;
					}
			}
			}
		}
		return $value;
	}
	
	/**
	 * Function: ced_add_wholesale_role
	 * Version:1.0.0
	 * Description : Adding a Role 'Wholesale Customer' by clicking Approve button
	 * @since  1.0.0
	 * @return void
	 */
	public function ced_add_wholesale_role() {
		add_role('wholesale_customer', __('WholeSale Customer'), array(
			'read' => true, // allows that capability
		));

		if (isset($_GET['approve'])) {
			$user_id = isset($_REQUEST['user_id']) ? sanitize_text_field($_REQUEST['user_id']) : false;
			$user    = new WP_User($user_id);
			// Remove role
			$user->remove_role($user->roles[0]);
			// Add role
			$user->add_role('wholesale_customer');
			update_user_meta($user_id, 'wholesale_customer_request', 'Approved');
		}
	}
}
