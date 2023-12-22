<?php
/**
 * Plugin Name: Stripe Payments
 * Description: Use shortcode [stripe_payment_button amount="AMOUNT" currency="CURRENCY" image="YOUR IMAGE OF SIZE 64x64" name="NAME" description="DESCRIPTION" button-text="BUTTON TEXT"] and fill the attributes of shortcode for smooth working of functionality.<a href="https://dashboard.stripe.com/live/payments" target="_blank">Click Here</a> to see payments.
 * Version: 1.0.0
 * Author: Devsea
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
// Plugin Defines
define( "FILE", __FILE__ );
define( "DIRECTORY", dirname(__FILE__) );
define( "TEXT_DOMAIN", dirname(__FILE__) );
define( "DIRECTORY_BASENAME", plugin_basename( FILE ) );
define( "DIRECTORY_PATH", plugin_dir_path( FILE ) );
define( "DIRECTORY_URL", plugins_url( null, FILE ) );
// Perform setup tasks when the plugin is activated
register_activation_hook(__FILE__, 'my_button_plugin_activate');
function my_button_plugin_activate() {
  // Perform any necessary setup tasks upon activation
}

// Define the shortcode functionality
add_shortcode('stripe_payment_button', 'my_button_shortcode');
function my_button_shortcode($atts) {
  // Extracting attributes, defaulting to empty values if not provided
  $atts = shortcode_atts(array(
      'amount' => '1',
      'currency' => 'cad',
      'image'=>'https://stripe.com/img/documentation/checkout/marketplace.png',
      'name' => 'Name',
      'description' => 'Description',
      'button-text' => 'Pay With Stripe'
  ), $atts);

  // Retrieving attribute values
  $amount = $atts['amount'];
  $currency = $atts['currency'];
  $image = $atts['image'];
  $name = $atts['name'];
  $description = $atts['description'];
  $buttonText = $atts['button-text'];

  // Generating button HTML with the passed attributes
  $button_html = '<button class="customButton" data-amount="' . esc_attr($amount) . '" data-currency="' . esc_attr($currency) . '" data-image="' . esc_attr($image) .'" data-name="' . esc_attr($name) . '" data-description="' . esc_attr($description) .'" >'.esc_attr($buttonText).'</button>';

  return $button_html;
}
// Enqueue custom CSS
add_action('wp_enqueue_scripts', 'my_button_plugin_enqueue_styles');
function my_button_plugin_enqueue_styles() {
  wp_enqueue_script('jquery');
   wp_enqueue_script('stripe-button-script', plugin_dir_url(__FILE__) . 'js/stripe.js', array('jquery'), '1.0.0', true);
   wp_enqueue_script('stripe-checkout', 'https://checkout.stripe.com/checkout.js');
    // Enqueue your custom CSS file
    wp_enqueue_style('stripe-button-style', plugin_dir_url(__FILE__) . 'css/style.css', array(), '1.0.0', 'all');

    $plugin_base_url = plugins_url('/', __FILE__);
    wp_localize_script('stripe-button-script', 'pluginData', array(
        'baseUrl' => $plugin_base_url,
        'publishableKey' => get_option('publishable_key'),
        'secretKey' => get_option('secret_key'),
        'thankYouPageUrl' => get_option('thank_you_page_url'),
        'cancelPageUrl'=>get_option('cancel_page_url'),
    ));
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts');
function enqueue_admin_scripts( $atts ){
  wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__) . '/css/admin-style.css', array(), '1.0.7');
   }
// Register the single menu
function plugin_menu() {

  add_menu_page('Stripe Payments', 'Stripe Payments', 'manage_options', 'stripe-payments', 'main_settings','dashicons-money-alt');
}
add_action('admin_menu', 'plugin_menu');
function main_settings() {
  require_once( DIRECTORY_PATH . 'includes/general-settings.php' );
   
}

