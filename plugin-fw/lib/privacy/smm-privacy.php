<?php
!defined( 'ABSPATH' ) && exit; // Exit if accessed directly

if ( !class_exists( 'SMMS_Privacy' ) ) {
    /**
     * Class SMMS_Privacy
     * Privacy Class
     *
     * @author sam
     */
    class SMMS_Privacy {
        private static $_instance;

        private $_title;

        public static function get_instance() {
            return !is_null( self::$_instance ) ? self::$_instance : self::$_instance = new self();
        }

        /**
         * SMMS_Privacy constructor.
         */
        private function __construct() {
            $this->_title = apply_filters( 'smms_plugin_fw_privacy_policy_guide_title', _x( 'SMMS Plugins', 'Privacy Policy Guide Title', 'smms-plugin-fw' ) );
            add_action( 'admin_init', array( $this, 'add_privacy_message' ) );
        }

        /**
         * Adds the privacy message on SMMS privacy page.
         */
        public function add_privacy_message() {
            if ( function_exists( 'wp_add_privacy_policy_content' ) ) {
                $content = $this->get_privacy_message();

                if ( $content ) {
                    wp_add_privacy_policy_content( $this->_title, $this->get_privacy_message() );
                }
            }
        }

        /**
         * get the privacy message
         *
         * @return string
         */
        public function get_privacy_message() {
            $privacy_content_path = SMM_CORE_PLUGIN_TEMPLATE_PATH . '/privacy/html-policy-content.php';
            ob_start();
            $sections = $this->get_sections();
            if ( file_exists( $privacy_content_path ) )
                include $privacy_content_path;

            return apply_filters( 'smms_wcbk_privacy_policy_content', ob_get_clean() );
        }

        public function get_sections() {
            return apply_filters( 'smms_wcbk_privacy_policy_content_sections', array(
                'general'           => array(
                    'tutorial'    => _x( 'This sample language includes the basics around what personal data your store may be collecting, storing and sharing, as well as who may have access to that data. Depending on what settings are enabled and which additional plugins are used, the specific information shared by your store will vary. We recommend consulting with a lawyer when deciding what information to disclose on your privacy policy.', 'Privacy Policy Content', 'smms-plugin-fw' ),
                    'description' => '',
                ),
                'collect_and_store' => array(
                    'title' => _x( 'What we collect and store', 'Privacy Policy Content', 'smms-plugin-fw' )
                ),
                'has_access'        => array(
                    'title' => _x( 'Who on our team has access', 'Privacy Policy Content', 'smms-plugin-fw' )
                ),
                'share'             => array(
                    'title' => _x( 'What we share with others', 'Privacy Policy Content', 'smms-plugin-fw' ),
                ),
                'payments'          => array(
                    'title' => _x( 'Payments', 'Privacy Policy Content', 'smms-plugin-fw' )
                ),
            ) );
        }
    }
}

SMMS_Privacy::get_instance();