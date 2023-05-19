<?php

if ( !defined( 'ABSPATH' ) || !defined( 'SMMS_SMAPI_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements SMAPI_Subscription Cart Class
 *
 * @class   SMAPI_Subscription_Cart
 * @package SMMS WooCommerce Subscription
 * @since   1.0.0
 * @author  SMMS
 */
if ( !class_exists( 'SMAPI_Subscription_Cart' ) ) {

	/**
	 * Class SMAPI_Subscription_Cart
	 */
	class SMAPI_Subscription_Cart {

        /**
         * Single instance of the class
         *
         * @var \SMAPI_Subscription_Cart
         */
        protected static $instance;

		/**
		 * @var string
		 */
		public $post_type_name = 'smapi_subscription';
        public $title_label = 'Customer input';
        
        /**
         * Returns single instance of the class
         *
         * @return \SMAPI_Subscription_Cart
         * @since 1.0.0
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Constructor
         *
         * Initialize plugin and registers actions and filters to be used
         *
         * @since  1.0.0
         * @author sam
         */
        public function __construct() {
            
            add_filter( 'woocommerce_cart_item_price', array($this, 'change_price_in_cart_html'), 10, 3);
            add_filter( 'woocommerce_quantity_input_args', array($this, 'smm_woocommerce_quantity_changes'), 10, 2 );
            add_filter( 'woocommerce_cart_item_subtotal', array($this, 'change_price_in_cart_html'), 10, 3);
            add_action( 'woocommerce_after_shop_loop_item',array($this, 'subscribe_arrow') );
            add_action( 'woocommerce_before_add_to_cart_button',array($this, 'smm_cfwc_display_custom_field' ));
            add_filter( 'woocommerce_add_to_cart_validation',array($this, 'smm_cfwc_validate_custom_field'), 10, 3 );
            add_filter( 'woocommerce_add_cart_item_data',array($this, 'smm_cfwc_add_custom_field_item_data'), 10, 4 );
            add_filter( 'woocommerce_cart_item_name',array($this, 'smm_cfwc_cart_item_name'), 10, 3 );
            add_action( 'wp_enqueue_scripts',array($this, 'prefix_enqueue_scripts' ), 10, 3 );
            
            add_action('woocommerce_after_add_to_cart_button', array($this,'smm_wc_text_after_quantity'),10,1); 
            add_filter( 'formatted_woocommerce_price', array($this, 'smm_ts_woo_decimal_price'), 10, 5 );
            add_action( 'wp_ajax_prefix_selected_variation_id',array($this, 'prefix_selected_variation_id' ), 10, 4 );
            add_action( 'wp_ajax_custom_input_data_id',array($this, 'get_custom_input_data' ), 10, 4 );
            add_action( 'wp_ajax_nopriv_custom_input_data_id',array($this, 'get_custom_input_data' ), 10, 4 );
            add_action( 'wp_ajax_subscription_select_data',array($this, 'set_subscription_select_data' ), 10, 4 );
            add_action( 'wp_ajax_nopriv_subscription_select_data',array($this, 'set_subscription_select_data' ), 10, 4 );
            
            add_filter( 'woocommerce_calculated_total',array($this, 'smm_calculated_total'), 10, 2 );
        }
        public function smm_wc_text_after_quantity() {
            global $product;
            $api_check_box_enabled = 
                smm_get_prop( $product, '_smapi_api' ) == "yes" ? 1 : null ;
                
                
            if ( is_product() && $api_check_box_enabled == 1 ) {
                $Min = 100;
                $Max = 1000;
                //SERVER ID AND ITEM ID TAKEN FROM PRODUCT OBJECT
	            $api_server_list_options_saved = 
	            smm_get_prop( $product, '_smapi_server_name_option' );
	            $api_item_list_options_saved   = 
	            smm_get_prop( $product, '_smapi_service_id_option' );
	            $order_item_meta =   
                get_post_meta( $api_server_list_options_saved, $api_item_list_options_saved, true );
	        
	            $order_item_meta_obj = json_decode($order_item_meta);
  
                $Min = $order_item_meta_obj->f_min_order; 
                $Max = $order_item_meta_obj->f_max_order; 
                
                printf('<div class="min-max-qty">Min %d  Max %d </div>',$Min,$Max);
                }
        }
        public function smm_calculated_total( $total, $cart){
           // Iterate through each cart item
                    $subcribed=0;
                    foreach( $cart->get_cart() as $value ) {
                     if( isset( $value['subscribe_price'] ) ) {
                     $price = ($value['subscribe_price']-1)*$value['line_total'];
                     $subcribed +=$price;
                   
                     }
                    } 
          return round( $total + $subcribed, $cart->dp );  
        }
        
        public function set_subscription_select_data(){
            $smm_session_data = 
            isset($_POST['sub_smm_data']) ? 
            sanitize_text_field($_POST['sub_smm_data']) : 'NA';
            $smm_session_product_id = 
            isset($_POST['smm_session_product']) ? 
            sanitize_text_field($_POST['smm_session_product']) : 'NA';
            $sub_smm_text = isset($_POST['sub_smm_text']) ? 
            sanitize_text_field($_POST['sub_smm_text']) : 'NA';
            if (strpos($sub_smm_text, 'day'))
            $price_time_option_string = 'day';
            if (strpos($sub_smm_text, 'week'))
            $price_time_option_string = 'week';
            if (strpos($sub_smm_text, 'month'))
            $price_time_option_string = 'month';
            
            $product            = wc_get_product( $smm_session_product_id );
            $price_is_per       = smm_get_prop( $product, '_smapi_price_is_per' );
	        $price_time_option  = smm_get_prop( $product, '_smapi_price_time_option' );
	        if($price_time_option_string == '')
	        $price_time_option_string = smapi_get_price_per_string( $price_is_per,$price_time_option);
	        
	        $price_time_option_string = $smm_session_data <2 ? 
	        " ".$price_time_option_string:
	        " ".$price_time_option_string.'s';
	        
            if( ( $data = WC()->session->get('subscribe_smm_data') ) )
            {
                
                $data[$smm_session_product_id]    = $smm_session_data;
                //data changes if the post carries a value
                $data['price_time_option_string'] = ($price_time_option_string == "  ") ?
                $data['price_time_option_string'] : $price_time_option_string;
                $data['smm_session_data']         = $price_time_option_string;
                WC()->session->set( 'subscribe_smm_data', $data );
            }
        
            wp_send_json( array( 'success'      => 1 ,
                                 'sub_smm_cycle'=> $price_time_option_string,
                                 'sub_smm_data' => $data[$smm_session_product_id]) );
            exit;
        }
        public function subscribe_arrow(){
            global $product;
            if ( SMMS_WC_Subscription()->is_subscription( $product->get_id() ) )
            {
            if ( isset(WC()->session) && ! WC()->session->has_session() ) {
                    WC()->session->set_customer_session_cookie( true );
                }
            // Set the session data
            WC()->session->set( 'subscribe_smm_data', array( $product->get_id() => 1,'price_time_option_string'=>'day' ) );    
            
            printf(
                '<div class="smm-counter"></div>
                    <div class="paginate left" smm_session_product= "%d"><i></i><i></i></div>
                    <div class="paginate right"><i></i><i></i></div>',$product->get_id()
                    );
            }
            
        }
        
        public function smm_ts_woo_decimal_price( $formatted_price, $price, $decimal_places, $decimal_separator, $thousand_separator ) {
	        $unit = number_format( intval( $price ), 0, $decimal_separator, $thousand_separator );
	        $decimal = substr(($price  - intval($unit)),2,$decimal_places);
	        
	        return $unit . '<sup>' . $decimal . '</sup>';
	        
        }
        /**
        * Enqueue our JS file
        */
        public function prefix_enqueue_scripts() {
         wp_register_script( 'prefix-script', trailingslashit( plugin_dir_url( __DIR__ ) ) . 'assets/js/smm-update-cart-item-ajax.js', array( 'jquery-blockui' ), time(), true );
         wp_register_style('smm_frontend',trailingslashit( plugin_dir_url( __DIR__ ) ).'assets/css/frontend.css',array(), '1', 'all' );
         wp_localize_script(
         'prefix-script',
        'prefix_vars',
         array(
         'ajaxurl' => admin_url( 'admin-ajax.php' )
         )
        );
        wp_enqueue_script( 'prefix-script' );
        wp_enqueue_style( 'smm_frontend' );
        }
         // set the step for specific qty for smm items)

        public function smm_woocommerce_quantity_changes( $args, $product ) {
            // FIND FOR Variation qty attribute different from english
            $SMMS_QTYLANG = (get_option('smmqty_attribute') != 'Quantity')?
            get_option('smmqty_attribute'):'Quantity';
            if($SMMS_QTYLANG =='')$SMMS_QTYLANG = 'quantity';
            $product_name = $product->get_name();
                // get quantity from product name title
	            $smm_title_pack  = mb_substr($product_name, 0, 5);
	            $smm_result_num = filter_var($smm_title_pack, FILTER_SANITIZE_NUMBER_INT);
	            //quantity overrides the order qunatity
	            if (is_numeric($smm_result_num))
	            $quantity_from_title = $smm_result_num; 
	            
                if($product->is_type( 'simple' ) && ! is_cart() && empty($quantity_from_title)){
                $api_check_box_enabled = 
                smm_get_prop( $product, '_smapi_api' ) == "yes" ? 1 : null ;
                if ( $api_check_box_enabled == 1) {
                //SERVER ID AND ITEM ID TAKEN FROM PRODUCT OBJECT
	            $api_server_list_options_saved = 
	            smm_get_prop( $product, '_smapi_server_name_option' );
	            $api_item_list_options_saved   = 
	            smm_get_prop( $product, '_smapi_service_id_option' );
	            $order_item_meta =   
                get_post_meta( $api_server_list_options_saved, $api_item_list_options_saved, true );
	        
	            $order_item_meta_obj = json_decode($order_item_meta);
  
                $args['input_value'] = $order_item_meta_obj->f_min_order; // Start from this value (default = 1) 
                $args['max_value']   = $order_item_meta_obj->f_max_order; // Max quantity (default = -1)
                $args['min_value']   = $order_item_meta_obj->f_min_order; // Min quantity (default = 0)
                $args['step']        = $order_item_meta_obj->f_min_order; // Increment/decrement by this value (default = 1)
                }
                return $args;   
                }// end of simple product
                if($product->is_type( 'variable' ) && ! is_cart() && empty($quantity_from_title)){
                    foreach( $product->get_children() as $key => $variation_id ) {
                    // Get an instance of the WC_Product_Variation Object
                    $variation = wc_get_product( $variation_id );
                    $api_check_box_enabled = 
                    get_post_meta( $variation_id, 'variable_smm_api', true ) =='on' ? 1 : null;
                    // Get the variation attributes
                    $variation_attributes = $product->get_variation_attributes();
                        // Loop through each selected attributes
                        foreach($variation_attributes as $attribute_taxonomy => $term_slug ){
                            // Get product attribute name or taxonomy
                            $taxonomy = str_replace('attribute_', '', $attribute_taxonomy );
                            // The label name from the product attribute
                            $attribute_name = wc_attribute_label( $taxonomy, $product );
                            // The term name (or value) from this attribute
                            if( taxonomy_exists($taxonomy) ) {
                            $attribute_value = get_term_by( 'slug', $term_slug, $taxonomy )->name;
                            } else {
                                $attribute_value = 
                                $term_slug; // For custom product attributes
                                }
                            if(preg_match('/'.$SMMS_QTYLANG.'/i', $attribute_name))
                            $quantity_attribute = $attribute_value;
                        
                            }// end of Loop through each selected attributes
                    if ( $api_check_box_enabled == 1 && empty($quantity_attribute)) {
                    //SERVER ID AND ITEM ID TAKEN FROM VARIATIOON OBJECT 
                    $api_item_list_options_saved = 
                    get_post_meta( $variation_id, 'var_smapi_service_id_option', true );
                
			        $api_server_list_options_saved = 
			        get_post_meta( $variation_id, 'var_smapi_server_name_option', true );
			        $order_item_meta =   
                    get_post_meta( $api_server_list_options_saved, $api_item_list_options_saved, true );
	        
	                $order_item_meta_obj = json_decode($order_item_meta);
  
                    $args['input_value'] = 
                    $order_item_meta_obj->f_min_order; // Start from this value (default = 1) 
                    $args['max_value'] = 
                    $order_item_meta_obj->f_max_order; // Max quantity (default = -1)
                    $args['min_value'] = 
                    $order_item_meta_obj->f_min_order; // Min quantity (default = 0)
                    $args['step'] = 
                    $order_item_meta_obj->f_min_order; // Increment/decrement by this value (default = 1)
                    }
                    }
                        return $args;
                    }// end of product variations
                return $args;
        }
         
         
                /**
                 * Update selected variation id through ajax
                */
        public function prefix_selected_variation_id() {
        global $post;
        /*/ Do a nonce check
        if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'woocommerce-cart' ) ) {
        wp_send_json( array( 'nonce_fail' => 1 ) );
        exit;
        }*/
        // Save the notes to the cart meta
        //$cart = WC()->cart->cart_contents;
        update_post_meta( $variation_id, 'var_id_sel', "0" );
        $cart_id = isset($_POST['cart_id']) ? 
            sanitize_text_field($_POST['cart_id']) : 'NA';
        
        update_post_meta( $cart_id, 'var_id_sel', $cart_id );
	    //$notes = $_POST['cart_id'];
	    //$var_selected['var_id_sel'] == $cart_id;
	    
	    //$cart_item = $cart[$cart_id];
	    //$cart_item['notes'] = $notes;
	    //WC()->cart->cart_contents['var_id_sel'] = $cart_item;
         wp_send_json( array( 'success' => 1 , 'text' => $cart_id) );
         exit;
        }
        // geting customer input from cart page
        public function get_custom_input_data(){
         $cart_id = isset($_POST['cartkey']) ? 
            sanitize_text_field($_POST['cartkey']) : 'NA';
          
         $customer_data = isset($_POST['customer_data']) ? 
            sanitize_text_field($_POST['customer_data']) : 'NA';
         
         $cart_updated_item = WC()->cart->get_cart_item( $cart_id );
         $cart_item_meta = WC()->cart->cart_contents;
         $product_id = $cart_updated_item['product_id'];
         foreach ($cart_item_meta as $key => $item) {
            if($key == $cart_id){
             //file_put_contents(plugin_dir_path( __FILE__ )."check.txt", $key.PHP_EOL,FILE_APPEND);
            $cart_qty = $item['quantity'];
            $variation_id = $item['variation_id'];
            $variation = $item['variation'];
            WC()->cart->remove_cart_item($key);
            }
         }
         WC()->cart->add_to_cart( $cart_updated_item['product_id'],$cart_qty, $variation_id, $variation, 
         array('smm-cfwc-title-field' => $customer_data) );
         wp_send_json( array( 'success' => 1 , 'text' => "Cart Item updated") );
         exit;  
        }
        

        /** 
        * Display custom field on the front end
        * @since 1.0.0
        */
        public function smm_cfwc_display_custom_field() {
                global $post;
                // Check for the custom field value
                $product = wc_get_product( $post->ID );
                if($product->is_type( 'simple' )){
                $title = $product->get_meta( 'smm_custom_text_field_title' ) ? $product->get_meta( 'smm_custom_text_field_title' ):'title is empty';
                $input_text_box_radio_saved   = smm_get_prop( $product, 'locate_input_box' ); 
                // FIND FOR SMM API CHECK BOX
                $api_check_box_enabled = 
                smm_get_prop( $product, '_smapi_api' ) == "yes" ? 1 : null ;
                if( $title && $input_text_box_radio_saved == 'product' && $api_check_box_enabled == 1) {
                // Only display our field if we've got a value for the field title
                printf(
                '<div class="smm-cfwc-custom-field-wrapper"><label for="smm-cfwc-title-field" style="display:inline-block;">%s</label><input type="text" id="smm-cfwc-title-field" name="smm-cfwc-title-field" value=""></div>',
                    esc_html( $title .' * : ' )
                    );
                    }
                }
                if($product->is_type( 'variable' )){
                // Loop through the variation IDs

                    foreach( $product->get_children() as $key => $variation_id ) {
                    // Get an instance of the WC_Product_Variation Object
                    $variation = wc_get_product( $variation_id );
            
                    // Get meta of variation ID
                    $var_smm_customer_input_field_label = $variation->get_meta( 'var_smm_customer_input_field_label' );
                    $api_check_box_enabled = get_post_meta( $variation_id, 'variable_smm_api', true ) =='on' ? 1 : null;
                    $locate_input_box = get_post_meta( $variation_id, 'locate_input_box', true );
                    
                    if($api_check_box_enabled == 1 && $locate_input_box == "product" && $var_smm_customer_input_field_label != ""){
                        // Output
                        
                    printf(
                    '<div class="var_smm_customer_input_field_label var_smm_customer_input_field_label-' . $variation_id .'"><label for="var_smm_customer_input_field_text" style="display:inline-block;">%s</label><input type="text" id="var_smm_customer_input_field_text_' . $variation_id .'" name="var_smm_customer_input_field_text[]" value=""></div>',
                    esc_html( $var_smm_customer_input_field_label .' * : ' )
                    );
                    }
                    }//end of foreach
                    
                    //script is on smm-update-cart-item-ajax.js
                    
                    }
            }
            /**
            * Validate the text field
            * @since 1.0.0
            * @param Array 		$passed					Validation status.
            * @param Integer   $product_id     Product ID.
             * @param Boolean  	$quantity   		Quantity
              */
            public function smm_cfwc_validate_custom_field( $passed, $product_id, $quantity ) {
    
                global $wpdb;
 	            $product = wc_get_product( $product_id );
                if($product->is_type( 'simple' )){
 	            $smm_api_checked   = smm_get_prop( $product, '_smapi_api' );   
                smm_get_prop( $product, '_smapi_price_is_per' );
                $input_text_box_radio_saved   = smm_get_prop( $product, 'locate_input_box' ); 
                if( empty( $_POST['smm-cfwc-title-field'] ) && $smm_api_checked =='yes' && $input_text_box_radio_saved == 'product') {
                // Fails validation
                $passed = false;
                wc_add_notice( __( 'Please enter a value into the text field marked! *', 'smm-api' ), 'error' );
                    }
                
                }
                if($product->is_type( 'variable' )){
                    
                    
                    
                    foreach( $product->get_children() as $key => $variation_id ) {
                        $selected = get_post_meta( $variation_id, 'var_id_sel', true );
                        update_post_meta( $variation_id, 'var_id_sel', "" );
                      
                        if($selected == $variation_id){
                        
                        // Get an instance of the WC_Product_Variation Object
                        $variation = wc_get_product( $variation_id );
            
                        // Get meta of variation ID
                    
                        $api_check_box_enabled = get_post_meta( $variation_id, 'variable_smm_api', true ) =='on' ? 1 : null;
                        $locate_input_box = get_post_meta( $variation_id, 'locate_input_box', true );
                    //file_put_contents(plugin_dir_path( __FILE__ )."check1.txt", serialize($_POST['var_smm_customer_input_field_text'])." check box = ".$api_check_box_enabled." varidclicked = ".$selected." foreach varid = ".$variation_id." locate = ".$locate_input_box." arryfilt = ".array_filter($_POST['var_smm_customer_input_field_text'] ),FILE_APPEND);
                 
                        // check if text field is empty for array
                    
                            if( empty( array_filter($_POST['var_smm_customer_input_field_text'] )) && $api_check_box_enabled == 1 && 
                            $locate_input_box == 'product'){
                    
                            // Fails validation
                            $passed = false;
                             wc_add_notice( __( 'Please enter a value into the text field marked for variation! *', 'smm-api' ), 'error' );    
                    
                            }
                        }
                    }//end of foreach
                }//end of product variable
                return $passed;
                }
            /**
             * Add the text field as item data to the cart object
             * @since 1.0.0
             * @param Array 	$cart_item_data Cart item meta data.
             * @param Integer   $product_id     Product ID.
             * @param Integer   $variation_id   Variation ID.
             * @param Boolean  	$quantity   		Quantity
             */
            public function smm_cfwc_add_custom_field_item_data( $cart_item_data, $product_id, $variation_id, $quantity ) {
            if( ! empty( $_POST['smm-cfwc-title-field'] ) ) {
            // Add the item data to cart
             $cart_item_data['smm-cfwc-title-field'] = isset($_POST['smm-cfwc-title-field']) ? 
            sanitize_text_field($_POST['smm-cfwc-title-field']) : 'NA';
             $product = wc_get_product($product_id); // The WC_Product Object
                    $price = (float) $product->get_price();
                    if( ( $data = WC()->session->get('subscribe_smm_data') ) )
            {
                $smm_session_data = $data[$product_id] ;
                
                
                $cart_item_data['subscribe_price'] = $smm_session_data;
            //file_put_contents(plugin_dir_path( __FILE__ )."check.txt", $price." ".$quantity.' '.$smm_session_data.' '.$cart_item_data['subscribe_price'].PHP_EOL,FILE_APPEND);
             
                
            }
                    
             }
             //record only if value is a string for variations $result = array_filter( $array, 'strlen' );
             if( @is_array($_POST['var_smm_customer_input_field_text']) && ! empty( 
                 array_filter($_POST['var_smm_customer_input_field_text'] )) ) {
                 foreach ($_POST['var_smm_customer_input_field_text'] as $item)
                 if($item != '')
                 $cart_item_data['smm-cfwc-title-field'] =  $item;
                 
             }
             
             return $cart_item_data;
            }
            /**
            * Display the custom field value in the cart
             * @since 1.0.0
             */
            public function smm_cfwc_cart_item_name( $name, $cart_item, $cart_item_key ) {
            // file_put_contents(plugin_dir_path( __FILE__ )."check.txt", serialize($cart_item));
            $product = $cart_item['data'];
            $api_check_box_enabled = 
                smm_get_prop( $product, '_smapi_api' ) == "yes" ? 1 : null ;
                $sub_text_display = "Single Order";
            if( ( $data = WC()->session->get('subscribe_smm_data') ) ){
            $smm_session_data           = isset($data[$product->get_id()])?$data[$product->get_id()]:'';//frequency
            $price_time_option_string   = $data['price_time_option_string'];
            $sub_text_display           = $smm_session_data != 1 ?
            "Subsciption added for ".$smm_session_data." ".$price_time_option_string :
                "Single Order";
                    }
                if( isset( $cart_item['smm-cfwc-title-field'] ) ) {
                    $name .= sprintf(
                    '<p class="smm-custom-input">Customer Input Item : %s</p>
                    <p class="smm-custom-input">%s</p>',
                    esc_html( $cart_item['smm-cfwc-title-field'] ),
                    $sub_text_display
                    );
                    }
                elseif($api_check_box_enabled ==1){
                 
                $name .= sprintf('<div class="smm-custom-input">Customer Input Item : <span 
                                class="smm-custom-data" id ="'.$cart_item_key.'" >Enter Input</span></div>',
                                @esc_html( $cart_item['smm-cfwc-title-field'] )
                                ); 
                    }
                
                 
                 return $name;
            }

		/**
		 * @param $price
		 * @param $cart_item
		 * @param $cart_item_key
		 *
		 * @return string
		 */
		public function change_price_in_cart_html(  $price, $cart_item, $cart_item_key ) {

			$product_id = ! empty( $cart_item['variation_id'] ) ? $cart_item['variation_id'] : $cart_item['product_id'];

            if ( !SMMS_WC_Subscription()->is_subscription( $product_id ) ) {
                
                return $price;
            }

            $product = $cart_item['data'];

            $price_is_per = smm_get_prop( $product, '_smapi_price_is_per' );
            $price_time_option = smm_get_prop( $product, '_smapi_price_time_option' );
			$price_is_per = smapi_get_price_per_string( $price_is_per,$price_time_option);
            if( ( $data = WC()->session->get('subscribe_smm_data') ) ){
            $smm_session_data           = $data[$product->get_id()];//frequency
            $price_time_option_string   = $data['price_time_option_string'];
            }
            //remove s for making singular
            if($smm_session_data != 1)
            $price .=  ' / '.substr($price_time_option_string, 0, -1); 
            

            return $price;
            
        }
    }
}

/**
 * Unique access to instance of SMAPI_Subscription_Cart class
 *
 * @return \SMAPI_Subscription_Cart
 */
function SMAPI_Subscription_Cart() {
    return SMAPI_Subscription_Cart::get_instance();
}