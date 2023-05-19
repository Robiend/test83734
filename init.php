<?php
/*
Plugin Name: SMM API & WOOCOMMERCE SUBSCRIPTION
Plugin URI: https://softnwords.com/themes/plugins/smm-api/
Description: SMM API Plugin helps online order processing at remote SMM servers.Perfect for SMM Panel websites and triggers orders at backend.It shows reports in Admin page.
Version: 6.0.5
Author: Softnwords
Author URI: https://softnwords.com/
Text Domain: smm-api
Domain Path: /languages/
WC requires at least: 3.7.1
WC tested up to: 3.7.1
*/
! defined( 'SMMS_SMAPI_PREMIUM_VERSION' ) && define( 'SMMS_SMAPI_PREMIUM_VERSION', '3.0.1.1');

/*
 * @package SMMS WooCommerce Subscription
 * @since   1.0.0
 * @author  SMMS
 *
 */
! defined( 'SMMS_SMAPI_PREMIUM_SUPPORT' ) && define( 'SMMS_SMAPI_PREMIUM_SUPPORT', 'https://softnwords.com/my-account/support/dashboard/');


if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}


if ( ! defined( 'SMMS_SMAPI_DIR' ) ) {
    define( 'SMMS_SMAPI_DIR', plugin_dir_path( __FILE__ ) );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'smm_maybe_plugin_fw_loader' ) && file_exists( SMMS_SMAPI_DIR . 'plugin-fw/init.php' ) ) {
    require_once( SMMS_SMAPI_DIR . 'plugin-fw/init.php' );
}
smm_maybe_plugin_fw_loader( SMMS_SMAPI_DIR  );

// This version can't be activate if premium version is active  ________________________________________
if ( defined( 'SMMS_SMAPI_PREMIUM' ) ) {
    function smms_smapi_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can activate the free version of SMMS WooCommerce Subscription.', 'smm-api' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'smms_smapi_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;

}

// Registration hook  ________________________________________
if ( !function_exists( 'smms_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/smm-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'smms_plugin_registration_hook' );

if ( !function_exists( 'smms_smapi_install_woocommerce_admin_notice' ) ) {
    function smms_smapi_install_woocommerce_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'SMMS API WooCommerce Subscription is enabled but not effective. It requires WooCommerce in order to work.', 'smm-api' ); ?></p>
        </div>
    <?php
    }
}

// Define constants ________________________________________
if ( defined( 'SMMS_SMAPI_VERSION' ) ) {
    return;
}else{
    define( 'SMMS_SMAPI_VERSION', SMMS_SMAPI_PREMIUM_VERSION );
}

! defined( 'SMMS_SMAPI_FREE_INIT' ) && define( 'SMMS_SMAPI_FREE_INIT', plugin_basename( __FILE__ ) );
! defined( 'SMMS_SMAPI_INIT' ) && define( 'SMMS_SMAPI_INIT', plugin_basename( __FILE__ ) );
! defined( 'SMMS_SMAPI_FILE' ) && define( 'SMMS_SMAPI_FILE', __FILE__ );
! defined( 'SMMS_SMAPI_URL' ) &&  define( 'SMMS_SMAPI_URL', plugins_url( '/', __FILE__ ) );
! defined( 'SMMS_SMAPI_ASSETS_URL' ) && define( 'SMMS_SMAPI_ASSETS_URL', SMMS_SMAPI_URL . 'assets' );
! defined( 'SMMS_SMAPI_TEMPLATE_PATH' ) && define( 'SMMS_SMAPI_TEMPLATE_PATH', SMMS_SMAPI_DIR . 'templates' );
! defined( 'SMMS_SMAPI_INC' ) && define( 'SMMS_SMAPI_INC', SMMS_SMAPI_DIR . '/includes/' );
! defined( 'SMMS_SMAPI_TEST_ON' ) && define( 'SMMS_SMAPI_TEST_ON', false );
! defined( 'SMMS_SMAPI_SLUG' ) && define( 'SMMS_SMAPI_SLUG', 'smm-api' );

if ( ! defined( 'SMMS_SMAPI_SUFFIX' ) ) {
    $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    define( 'SMMS_SMAPI_SUFFIX', $suffix );
}



if ( ! function_exists( 'smms_smapi_install' ) ) {
    function smms_smapi_install() {

        if ( !function_exists( 'WC' ) ) {
            add_action( 'admin_notices', 'smms_smapi_install_woocommerce_admin_notice' );
        } else {
            do_action( 'smms_smapi_init' );
        }
    }

    add_action( 'plugins_loaded', 'smms_smapi_install', 11 );
}


function smms_smapi_constructor() {

    // Woocommerce installation check _________________________
    
    if ( !function_exists( 'WC' ) ) {
        function smms_smapi_install_woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( 'SMMS API WooCommerce Subscription is enabled but not effective. It requires WooCommerce in order to work.', 'smm-api' ); ?></p>
            </div>
        <?php
        }

        add_action( 'admin_notices', 'smms_smapi_install_woocommerce_admin_notice' );
        return;
    }

    // Load SMAPI text domain ___________________________________
    load_plugin_textdomain( 'smm-api', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    if( ! class_exists( 'WP_List_Table' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
    }

    require_once( SMMS_SMAPI_INC . 'functions.smms-wc-subscription.php' );
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription.php' );
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-api.php' );
	require_once( SMMS_SMAPI_INC . 'class.smapi-susbscription-helper.php' );
	require_once( SMMS_SMAPI_INC . 'class.smapi-susbscription.php' );
	require_once( SMMS_SMAPI_INC . 'class.smapi-smm-server.php' );
	require_once( SMMS_SMAPI_INC . 'class.smapi-smm-api-item.php' );
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription-order.php' );
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription-cart.php' );
	require_once( SMMS_SMAPI_INC . 'class.smapi-smm-ajax-call.php');
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription-admin.php' );
	require_once( SMMS_SMAPI_INC . 'class-smms-wc-ajax.php' );
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription-cron.php' );
	require_once( SMMS_SMAPI_INC . 'gateways/paypal/class.smms-wc-subscription-paypal.php' );
	require_once( SMMS_SMAPI_INC . 'admin/class.smapi-subscriptions-list-table.php' );
	require_once( SMMS_SMAPI_INC . 'admin/class.smapi-smm-servers-list-table.php' );
	require_once( SMMS_SMAPI_INC . 'admin/class.smapi-smm-orders-list-table.php' );
	require_once( SMMS_SMAPI_INC . 'admin/class.smapi-smm-api-items-list-table.php' );
	$smm_plugin_premium = WP_PLUGIN_DIR . '/smm-api-premium';
	
	require_once( SMMS_SMAPI_INC . 'class.smms-wc-subscription-privacy.php' );
    if ( is_dir( $smm_plugin_premium ) ) {
    // plugin premium directory found!
    if ( !defined( 'SMM_API_PREMIUM' ) )
        define ( 'SMM_API_PREMIUM', 'CODE');
   
        
    }
	if ( is_admin() ) {
        SMMS_WC_Subscription_Admin();
        SMMS_WC_AJAX();
	}

    SMMS_WC_Subscription();

    add_action( 'smapi_renew_orders', array( SMAPI_Subscription_Cron(), 'renew_orders') );


}
add_action( 'smms_smapi_init', 'smms_smapi_constructor' );