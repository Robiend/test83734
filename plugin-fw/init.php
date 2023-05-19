<?php
/**
 * This file belongs to the SMM Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly



if ( ! function_exists ( 'smm_maybe_plugin_fw_loader' ) ) {
    /**
     * smm_maybe_plugin_fw_loader
     *
     * @since 1.0.0
     */
    function smm_maybe_plugin_fw_loader ( $plugin_path ) {
        global $plugin_fw_data_smm, $plugin_upgrade_fw_data_smm;

        $default_headers = array (
            'Name'       => 'Framework Name',
            'Version'    => 'Version',
            'Author'     => 'Author',
            'TextDomain' => 'Text Domain',
            'DomainPath' => 'Domain Path',
        );

	    $plugin_path         = trailingslashit( $plugin_path );
	    $framework_data      = get_file_data( $plugin_path . 'plugin-fw/init.php', $default_headers );
	    $plugin_fw_main_file = $plugin_path . 'plugin-fw/smm-plugin.php';

        if ( ! empty( $plugin_fw_data_smm ) ) {
            foreach ( $plugin_fw_data_smm as $version => $path ) {
                if ( version_compare ( $version, $framework_data[ 'Version' ], '<' ) ) {
                    $plugin_fw_data_smm = array ( $framework_data[ 'Version' ] => $plugin_fw_main_file );
                }
            }
        } else {
            $plugin_fw_data_smm = array ( $framework_data[ 'Version' ] => $plugin_fw_main_file );
        }

	    if ( ! defined( 'SMMS_PLUGIN_FW_VERSION' ) ) {
		    $keys    = array_keys( $plugin_fw_data_smm );
		    $version = empty( $plugin_fw_data_smm ) ? '1.0.0' : array_pop( $keys );
		    define( 'SMMS_PLUGIN_FW_VERSION', $version );
	    }

        //Check for license & upgrade classes
	    $upgrade_fw_init_file = $plugin_path . 'plugin-upgrade/init.php';
	    $framework_data = file_exists( $upgrade_fw_init_file ) ? get_file_data( $upgrade_fw_init_file, $default_headers ) : $framework_data;
	    $plugin_license_path    = $plugin_upgrade_path = $plugin_path . 'plugin-upgrade';

        if( ! file_exists( $plugin_upgrade_path ) ){
        	//Check the path for OLD plugin FW
	        if( file_exists( $plugin_path . 'plugin-fw/licence' ) ){
		        $plugin_license_path = $plugin_path . 'plugin-fw/licence';
		        $plugin_upgrade_path = $plugin_path . 'plugin-fw/';
	        }

	        else {
		        $plugin_upgrade_path = $plugin_license_path = false;
	        }
        }

	    if( file_exists( $plugin_upgrade_path ) ){
		    if( ! empty( $plugin_upgrade_fw_data_smm ) ){
				foreach( $plugin_upgrade_fw_data_smm as $version => $files ){
					if( version_compare ( $version, $framework_data[ 'Version' ], '<' ) ){
						$plugin_upgrade_fw_data_smm = array ( $framework_data[ 'Version' ] => smm_get_upgrade_files( $plugin_license_path, $plugin_upgrade_path ) );
					}
				}
		    }

	    	else {
			    $plugin_upgrade_fw_data_smm = array ( $framework_data[ 'Version' ] => smm_get_upgrade_files( $plugin_license_path, $plugin_upgrade_path ) );
		    }
	    }
    }
}

if( ! function_exists( 'smm_get_upgrade_files' ) ){
	/**
	 * Retreive the core files to include to manage license and upgrade if exists
	 *
	 * @param $plugin_update_path file path
	 *
	 * @return array to files to include
	 */
	function smm_get_upgrade_files( $plugin_license_path, $plugin_upgrade_path = '' ){
		$to_include = array();

		if( false ==! $plugin_license_path ){
			$plugin_upgrade_path = empty( $plugin_upgrade_path ) ? $plugin_license_path : $plugin_upgrade_path;
			$license_files = array(
				'%smms-license-path%/lib/smm-licence.php',
				'%smms-license-path%/lib/smm-plugin-licence.php',
				'%smms-license-path%/lib/smm-theme-licence.php',
			);

			$upgrade_files = array( '%smms-upgrade-path%/lib/smm-plugin-upgrade.php' );

			$to_include_license = str_replace( '%smms-license-path%', $plugin_license_path, $license_files );
			$to_include_upgrade = str_replace( '%smms-upgrade-path%', $plugin_upgrade_path, $upgrade_files );

			$to_include = array_merge( $to_include_license, $to_include_upgrade );
		}

		return $to_include;
	}
}