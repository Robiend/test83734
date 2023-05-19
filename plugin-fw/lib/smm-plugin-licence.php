<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'SMM_Plugin_Licence' ) ) {
    /**
     * SMM Licence Panel
     *
     * Setting Page to Manage Products
     *
     * @class      SMM_Licence
     * @package    SMMS
     * @since      1.0
     * @author     sam
     */
    class SMM_Plugin_Licence {
	    /**
	     * @var object The single instance of the class
	     * @since 1.0
	     */
	    protected static $_instance = null;

        /**
         * Constructor
         *
         * @since    1.0
         * @author   sam softnwords
         */
        public function __construct() {
            //Silence is golden
        }

        /**
         * Premium products registration
         *
         * @param $init         string | The products identifier
         * @param $secret_key   string | The secret key
         * @param $product_id   string | The product id
         *
         * @return void
         *
         * @since    1.0
         * @author   sam softnwords
         */
        public function register( $init, $secret_key, $product_id ){
	        if( ! function_exists( 'SMMS_Plugin_Licence' ) ){
		        //Try to load SMMS_Plugin_Licence class
		        smms_plugin_fw_load_update_and_licence_files();
	        }

            try {
                SMMS_Plugin_Licence()->register( $init, $secret_key, $product_id  );
            } catch( Error $e ){
            }
        }

	    /**
	     * Main plugin Instance
	     *
	     * @static
	     * @return object Main instance
	     *
	     * @since  1.0
	     * @author sam softnwords
	     */
	    public static function instance() {
		    if ( is_null( self::$_instance ) ) {
			    self::$_instance = new self();
		    }

		    return self::$_instance;
	    }

	    /**
	     * Get license activation URL
	     *
	     * @author sam softnwords
	     * @since 3.0.17
	     */
	    public static function get_license_activation_url(){
		    return function_exists( 'SMMS_Plugin_Licence' ) ? SMMS_Plugin_Licence()->get_license_activation_url() : false;
	    }

	    /**
	     * Get protected array products
	     *
	     * @return mixed array
	     *
	     * @since  1.0
	     * @author sam softnwords
	     */
	    public function get_products() {
		    return function_exists( 'SMMS_Plugin_Licence' ) ? SMMS_Plugin_Licence()->get_products() : array();
	    }
    }
}

/**
 * Main instance
 *
 * @return object
 * @since  1.0
 * @author sam softnwords
 */
if ( !function_exists( 'SMM_Plugin_Licence' ) ) {
	function SMM_Plugin_Licence() {
		return SMM_Plugin_Licence::instance();
	}
}
