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
 *
 */
class Wholesale_Market_Public {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * 
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * 
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
	public function __construct( $plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wholesale-market-public.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wholesale-market-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('public_get_variation_js', plugin_dir_url(__FILE__) . 'js/get_variation_single_product.js', array('jquery'), $this->version, false);
		wp_localize_script(
			$this->plugin_name,
			'public_get_variation_js', //handle name
			array(
				'ajax_url' => admin_url('admin-ajax.php')
			)
		);
	}


	/**
	 * Function:ced__add_wholesale_customer_request_field_registration_form
	 * Description:Add a Checkbox to Select Whether User Want to Become Wholesale User Or Not
	 * Version :1.0.0
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function ced__add_wholesale_customer_request_field_registration_form() {
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			woocommerce_form_field(
				'wholesale_customer_request',
				array(
					'type'        => 'checkbox',
					'label'       => 'Become WholeSale Customer'
				)
			);
		}
	}

	/**
	 * Function :ced_add_user_request_for_wholesale_customer
	 * Description:Saving a Checkbox value  Whether User Want to Become Wholesale User Or Not
	 * Version :1.0.0
	 *
	 * @since  1.0.0
	 * @param  mixed $customer_id
	 * @return void
	 */
	public function ced_add_user_request_for_wholesale_customer( $customer_id) {
		if (isset($_POST['wholesale_customer_request'])) {
			update_user_meta($customer_id, 'wholesale_customer_request', wc_clean('requested'));
		}
	}


	/**
	 * Function :ced_show_wholesale_price
	 * Description: Displaying a Wholesale Price on Shop Page
	 * Version :1.0.0
	 *
	 * @since  1.0.0
	 * @var $product //Global Varibale For Product
	 * @var $checkstatus //Checking Status for Settting of wholesale_market_prices to show user end
	 * @var $productType //Getting Product Type
	 * @var $simpleProductPrice //Product Price
	 * @var $wholesalePriceprefix // Whole Sale Price Prefix
	 * @return void
	 */
	public function ced_show_wholesale_price() {
		global $product;
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			$checkstatus          = get_option('wholesale_market_prices_show_user_type');
			$wholesalePriceprefix = get_option('Wholesale_price_display');
			$productType          = $product->get_type();
			$simpleProductPrice   = get_post_meta(get_the_ID(), 'wholesale_simple_product_price', true);
			if ('all_customer' === $checkstatus) {
				if ('simple' === $productType) {
					if (!empty($simpleProductPrice)) {
						echo '<br>' . esc_html($wholesalePriceprefix) . esc_html(get_woocommerce_currency_symbol()) . esc_html($simpleProductPrice);
					}
				} else {
					return false;
				}
			} else {
				if (is_user_logged_in()) {
					$user = new WP_User(get_current_user_id());
					$role = $user->roles[0];
					if ('wholesale_customer' === $role) {
						if ('simple' === $productType) {
							if (!empty($simpleProductPrice)) {
								echo '<br>' . esc_html($wholesalePriceprefix) . esc_html(get_woocommerce_currency_symbol()) . esc_html($simpleProductPrice);
							}
						} else {
							return false;
						}
					}
				}
			}
		}
	}


	/**
	 * Function :ced_show_wholesale_variable_price_single_Page
	 * Description: Displaying a Wholesale Price on Single Page
	 * Version :1.0.0
	 * 
	 * @since  1.0.0
	 * @var $product //Global Varibale For Product
	 * @var $checkstatus //Checking Status for Settting of wholesale_market_prices to show user end
	 * @var $productType //Getting Product Type
	 * @var $simpleProductPrice //Product Price
	 * @var $wholesalePriceprefix // Whole Sale Price Prefix
	 * @return void
	 */
	public function ced_show_wholesale_variable_price_single_Page( $variation_data, $product, $variation) {
		global $product;
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			$checkstatus           = get_option('wholesale_market_prices_show_user_type');
			$wholesalePriceprefix  = get_option('Wholesale_price_display');
			$productType           = $product->get_type();
			$variationId           = $variation_data['variation_id'];
			$variationProductPrice = get_post_meta($variationId, 'wholesale_variation_price', true);
			if ('all_customer' === $checkstatus) {
				if ('variable' === $productType) {
					$variation_data['price_html'] .= $wholesalePriceprefix . ' <span class="price-suffix">' . wc_price($variationProductPrice, 'wholesale-market') . '</span>';
					return $variation_data;
				} else {
					return false;
				}
			} else {
				if (is_user_logged_in()) {
					$user = new WP_User(get_current_user_id());
					$role = $user->roles[0];
					if ('wholesale_customer' === $role) {
						if ('varible' === $productType) {
							$variation_data['price_html'] .= $wholesalePriceprefix . '</h4><span class="price-suffix">' . wc_price($variationProductPrice, 'wholesale-market') . '</span>';
							return $variation_data;
						} else {
							return false;
						}
					}
				}
			}
		}
		return $variation_data;
	}



	/**
	 * Ced_recalculate_price_wholesale
	 * Description : Modifying Product Price if Product quantity equal or Greater Then to  Wholesale Quantity 
	 * Version:1.0.0
	 * 
	 * @since 1.0.0
	 * @param  mixed $cart_object
	 * @var $checkSettingForQuantity
	 * @var $commonQuantity
	 * @var $productType
	 * @var $productId
	 * @var $variationId
	 * @var $cartProductQuantity
	 * @var $getPriceofProduct
	 * @return void
	 */
	public function ced_recalculate_price_wholesale( $cart_object) {
		if ('yes' === get_option('wholesale_market_checkbox_general')) {
			if (is_admin() && !defined('DOING_AJAX')) {
				return;
			}
			$checkSettingForQuantity = get_option('wholesale_market_prices_show_user');
			// For Common Qunatity Setting
			if ('set_common_quantity' == $checkSettingForQuantity) {
				$commonQuantity = get_option('Wholesale_minimum_quantity_all');
				foreach ($cart_object->cart_contents as $key => $value) {
					$productType = $value['data']->get_type();
					$productId   = $value['product_id'];
					$variationId = $value['variation_id'];
					if ('simple' == $productType) {
						$cartProductQuantity = $value['quantity'];
						if ($cartProductQuantity >= $commonQuantity) {
							$getPriceofProduct = get_post_meta($productId, 'wholesale_simple_product_price', true);
							$value['data']->set_price($getPriceofProduct);
						}
					}
					if ('variation' == $productType) {
						$cartProductQuantity = $value['quantity'];
						if ($cartProductQuantity >= $commonQuantity) {
							$getPriceofProduct = get_post_meta($variationId, 'wholesale_variation_price', true);
							$value['data']->set_price($getPriceofProduct);
						}
					}
				}
			} else {
				//For Product Level Quantity
				foreach ($cart_object->cart_contents as $key => $value) {
					$productType = $value['data']->get_type();
					$productId   = $value['product_id'];
					$variationId = $value['variation_id'];
					if ('simple' == $productType) {
						$cartProductQuantity      = $value['quantity'];
						$productWholesaleQuantity = get_post_meta($productId, 'wholesale_simple_product_min_qty', true);
						if ($cartProductQuantity >= $productWholesaleQuantity) {
							$getPriceofProduct = get_post_meta($productId, 'wholesale_simple_product_price', true);
							$value['data']->set_price($getPriceofProduct);
						}
					}

					if ('variation' == $productType) {
						$cartProductQuantity               = $value['quantity'];
						$variationProductWholesaleQuantity = get_post_meta($variationId, 'wholesale_variation_min_qty', true);
						if ($cartProductQuantity >= $variationProductWholesaleQuantity) {
							$getPriceofProduct = get_post_meta($variationId, 'wholesale_variation_price', true);
							$value['data']->set_price($getPriceofProduct);
						}
					}
				}
			}
		}
	}
}
