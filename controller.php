<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       ankurvishwakarma54@yahoo.com
 * @since      1.0.0
 *
 * @package    Avcl_Wp_Buy_Tickets
 * @subpackage Avcl_Wp_Buy_Tickets/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Avcl_Wp_Buy_Tickets
 * @subpackage Avcl_Wp_Buy_Tickets/admin
 * @author     Ankur Vishwakarma <ankurvishwakarma54@yahoo.com>
 */
class Avcl_Wp_Buy_Tickets_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function register_events_post_type(){
		$labels = array(
        'name'                  => _x( 'AVCL Events', 'AVCL Events', 'avclwpcl' ),
        'singular_name'         => _x( 'AVCL Event', 'Event', 'avclwpcl' ),
        'menu_name'             => _x( 'AVCL Events', 'Events', 'avclwpcl' ),
        'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'avclwpcl' ),
        'add_new'               => __( 'Add New', 'avclwpcl' ),
        'add_new_item'          => __( 'Add New Event', 'avclwpcl' ),
        'new_item'              => __( 'New Event', 'avclwpcl' ),
        'edit_item'             => __( 'Edit Event', 'avclwpcl' ),
        'view_item'             => __( 'View Event', 'avclwpcl' ),
        'all_items'             => __( 'All Events', 'avclwpcl' ),
        'search_items'          => __( 'Search Events', 'avclwpcl' ),
        'parent_item_colon'     => __( 'Parent Events:', 'avclwpcl' ),
        'not_found'             => __( 'No events found.', 'avclwpcl' ),
        'not_found_in_trash'    => __( 'No events found in Trash.', 'avclwpcl' ),
        'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'avclwpcl' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'avclwpcl' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'avclwpcl' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'avclwpcl' ),
        'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'avclwpcl' ),
        'insert_into_item'      => _x( 'Insert into event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'avclwpcl' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'avclwpcl' ),
        'filter_items_list'     => _x( 'Filter events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'avclwpcl' ),
        'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'avclwpcl' ),
        'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'avclwpcl' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => false,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'avcl-events' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => true,
        'menu_position'      => 99,
        'menu_icon'      	 => 'dashicons-feedback',
        'supports'           => array( 'title', 'editor' ),
    );
 
    register_post_type( 'avcl_events', $args );
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
		 * defined in Avcl_Wp_Buy_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Avcl_Wp_Buy_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/avcl-wp-buy-tickets-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'font-awosome', plugin_dir_url( __FILE__ ) . 'css/font-awosome-all.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
	

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
		 * defined in Avcl_Wp_Buy_Tickets_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Avcl_Wp_Buy_Tickets_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	
        global $post;

        $get_deafult_seat_count=get_option( 'avclwpcb_settings' );
        
      
        
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/avcl-wp-buy-tickets-admin.js', array( 'jquery' ), $this->version, false );
		
		wp_enqueue_script( $this->plugin_name.'block_ui', plugin_dir_url( __FILE__ ) . 'js/jquery.blockUI.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'font-awosome', plugin_dir_url( __FILE__ ) . 'js/font-awosome-all.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 

			                'avclwpc_admin_obj', 

		           			['ajax_url' => admin_url('admin-ajax.php'),
		           		     'avclwpc_security'=> wp_create_nonce('avclwpc_builder_ac'),
		           		     'new_builder_url' => admin_url().'admin.php?page=avclwpc-theater-builder',
		           		     'default_seats_in_builder'=> $get_deafult_seat_count['seats_per_row'],
		           		     'current_product_id'=>(!empty($post) ? $post->ID : 0),
		           		     'all_builders_field_array'=>avclwpc_generate_group_name_array_of_each_theater(),
		           		     'date_of_today'=>date_i18n("Y-m-d"),
		           		    ]

	    );

	}

    public function add_builder_menu(){
	    	
	    
	    	 
	    	        add_menu_page( 
						        __( 'Theater builder', 'avclwpcl' ),
						        'theater builder',
						        'manage_options',
						        'avclwpc-theater-builder',
						         [$this,'avclwpc_builder_customization'],
						        'dashicons-building',
						        99
    				             ); 
    			    add_submenu_page( 'avclwpc-theater-builder',
		    	     				  __('Settings', 'avclwpcl' ),
		    	                      'Settings',
		    	                      'manage_options',
		    	                      'avclwpc-theater-builder-setting',
		    	                      [$this, 'avclwpc_builder_setting_page_content']
		    	                     );

	  
    }
    public function avclwpc_builder_customization(){
    	
    	// Builder Main Page HTML
		do_action( 'avclwcb_add_builder_page' );
		
		//Builder's View HTML
    	do_action( 'avclwcb_before_builder_generator' );
    	
    	//New Form HTML
    	do_action( 'avclwcb_new_form' );   	 
    } 

    public function avclwpc_builder_setting_page_content(){
    	//containts builders all settings
    	if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'avclwpc-theater-builder-setting' ) {
    	   
    	    include_once(dirname(__FILE__).'/view/setting.php');
    	
    	}else{
			
			
    	}

    }
    public function avclwpc_do_builder_duplicate(){ //ajax for builder duplicating 
           
       check_ajax_referer('avclwpc_builder_ac','avclwpc_security');

        global $wpdb;
        $status=[];

        $id=(int)$_POST['id'];

       	if (!empty($id) && $id > 0 && $id != null) {
       	   $builder_data=get_post_meta( $id, 'avclwpcb_builder_data', true );
       	  
       	   if (is_serialized( $builder_data )) {
       	   	  $builder_data=unserialize($builder_data);
       	   }
       	
       	  
   	  	 	if (!empty($builder_data)) {	
    			$post_title=wp_strip_all_tags( $builder_data['theater_name']);
  	
	   	     		$my_post = array(
								  'post_title'    => $post_title."(copied)",
								  'post_content'  => '',	
								  'post_status'   => 'publish',
								  'post_type'     => 'avcl_events'
								
							   );
	            $new_post_id=(int)wp_insert_post( $my_post, true );

   	   	     	if ($new_post_id && $new_post_id != null) {

   	   	     		
   	   	     		 $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$id");
				    
				    if (count($post_meta_infos) != 0 ) {

				      $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
				      
				      foreach ($post_meta_infos as $meta_info) {
						        $meta_key = $meta_info->meta_key;
						        if( $meta_key == '_wp_old_slug' ) 
						        	continue;
						        $meta_value = addslashes($meta_info->meta_value);
						        $sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
				      }

				      $sql_query.= implode(" UNION ALL ", $sql_query_sel);
				      $update = $wpdb->query($sql_query);
				    }

   	   	     		if ($update) {
   	   	     			$post= get_post( $new_post_id, ARRAY_A );
							if ($post) {
								 $builder_data['theater_name']=$post['post_title'];
								 update_post_meta( $new_post_id, 'avclwpcb_builder_data' , $builder_data );
								 $status['name']=$post['post_title'];
							}else{
								$status['name']=$post_title;
							}
   	   	     			$status['success']=$new_post_id;
   	   	     			
   	   	     		}else{
   	   	     			$status['error']='Error While updating!';
   	   	     		}

   	   	     	}else{
				 	$status['error']='Error While Duplicating!';
				 	
				 }
			}else{
 				$status['error']='Data Of This Builder Seems Like Empty!';
   			}
       
		}else{
			$status['error']='Error While Fetching ID!';
		}
	echo json_encode($status);

	wp_die();
	}
	public function avclwpc_delete_builder(){
		
		$status=[];
        $id=(int)$_POST['id'];
       
        if (!empty($id) && $id > 0) {
        	$post= get_post( $id, ARRAY_A );

        	$deleted_post=wp_delete_post($id ,true);
        	if($deleted_post != false && $deleted_post != NULL ){
        		
        		$status['success']= 'success';
        		$status['name']   = $post['post_name'];
        		
        	}else{
        		$status['error']='Problem While Deletion!';
        	}

        }else{
        	$status['error']='In Deletion The Builder Id Making complication!';
        }
    
    echo json_encode($status);

    wp_die();    
	}
    public function avclwpc_theater_form(){
    	

    	if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'avclwpc-theater-builder') {

		    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'view') {
		     	
		     	if (isset($_REQUEST['id'])) {
		     		$post_id=(int)$_REQUEST['id'];

		     		if (!avclwpc_validateInteger($post_id) || $post_id <= 0) {
		     	
		     			return false;
		     		}else{
		     			 include_once(dirname(__FILE__).'/view/view_builder_data.php');
		     		}	
        	 	}
        	}
	    }
    }
    	
    
	public function avclwpc_main_page_html(){
    	 
	    if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'avclwpc-theater-builder') {

		   include_once(dirname(__FILE__).'/view/all_theaters_table.php');
		}	
	}
	public function avclwpc_generate_new_form(){

	    if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'avclwpc-theater-builder') {

		  	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') {
    		     	
		    	include_once(dirname(__FILE__).'/view/new_form.php');
		 	}
	    }
    }
	
	public function avclwpc_save_theater_data(){
    //save builder's data

		$toggle_btn=0;
		
    	if (isset($_POST['avclwpc_save_builder_data'])) {


    		if (isset($_POST['avclwpcb'])) {

    			$head_array=avclwpc_sanitize_array($_POST['avclwpcb']);
 
    			$theater_name=$head_array['theater_name'];
    			
    			if (avclwpc_validateInteger($_POST['avclwpc_toggle_switch_checkbox'])) {

		  			$toggle_btn=(int)$_POST['avclwpc_toggle_switch_checkbox'];
				}
			 	if (isset($_REQUEST['action'])) {
    		     	     
		           	if ($_REQUEST['action'] == 'view') {
    		     		
    		     		if (isset($_REQUEST['id'])) {
    		     			if (!avclwpc_validateInteger($_REQUEST['id'])) {
    		     				return false;
    		     			}
    		     			$id = (int)$_REQUEST['id'];
    		     			if (!empty($id)) {
    		     				
	    		                $get_post=get_post( $id ,ARRAY_A);
	    		                $get_post['post_name']=sanitize_title( $theater_name );
	    		                $get_post['post_title']=$theater_name;
	    		     			
	    		     			$post_id=(int)wp_update_post( $get_post, true );

    		     			}else{
	 
	    		     			return false;
    		     			}
    		     		}
    		     		
					}elseif ($_REQUEST['action'] == 'new') {
	        	 		    $my_post = array(
							  'post_title'    => $theater_name,
							  'post_content'  => '',
							  'post_status'   => 'publish',
							  'post_type'     => 'avcl_events'
							
						   );
				             $post_id=(int)wp_insert_post( $my_post, true );
				             
	        	 	}else{

	        	 		$post_id=0;
	        	 	}
	       
             
			 	if (is_wp_error($post_id)) {
					    
					    $errors = $post_id->get_error_messages();
					    foreach ($errors as $error) {
					       
    		     			new avclwpc_throw_messages($errors,'notice notice-error is-dismissible');
    		     			
					    }
				  	}elseif($post_id > 0) {
				  		
			  			$get_post=get_post( $post_id ,ARRAY_A);
			  			$head_array['theater_name']=$get_post['post_title'];
			  			
			  			update_option( 'avclwpcb_toggle_btn_'.$post_id, $toggle_btn );

 					 	$update= update_post_meta( $post_id, 'avclwpcb_builder_data', $head_array );
 					 	if ($update) {
 					 		wp_redirect(admin_url().'admin.php?page=avclwpc-theater-builder&action=view&id='.$post_id.'');
 					 	}
			      	}else{
 					 	new avclwpc_throw_messages('Data Not Saved Properly!','notice notice-error is-dismissible');
				  	}
		   	  	}
 		    }
		}
		
    }
  
  public function avclwpc_save_theater_settings(){

  		$container=[];

  		if (isset($_REQUEST['page']) && $_REQUEST['page'] == 'avclwpc-theater-builder-setting') {

			if (isset($_POST['avclwpcb_save_settings']) && isset($_POST['avclwpcb_settings'])) {
				
				if (!isset($_POST['avclwpc_theater_settings_nonce']) || !wp_verify_nonce($_POST['avclwpc_theater_settings_nonce'],'avclwpc_validate_settings')) {
	  				new avclwpc_throw_messages('Sorry, your nonce did not verify.','notice notice-error is-dismissible');
	  				return false;
	  			}
				if (!empty($_POST['avclwpcb_settings'])) {

				    $all_data_array=avclwpc_sanitize_array($_POST['avclwpcb_settings']);

				    foreach ($all_data_array as $key => $value) {
				    	
				    	if ($key == 'seats_per_row' ) {
				    	 	  $container['seats_per_row']=(!empty($value) ? $value : 20 );
			    	 	}elseif ($key == 'status_text') {
				    	 	  $container['status_text']=sanitize_text_field( $value );
			    	 	}
				    	
				    }

				 $success=update_option( 'avclwpcb_settings', $container );
				 if ($success) {
				 	new avclwpc_throw_messages('Settings Saved','notice notice-success is-dismissible');
				 }
				}
			}
		}
  }
  
  public function avclwpc_add_product_type_in_wc($types){

  		 $types['cinematic'] = 'Cinematic';
        
		 return $types;
  }

  public function avclwpc_show_product_tab($tabs){
  	
  		$tabs['cinematic'] = array(
						      'label'	 => __( 'Cinematic Product', 'avclwpcl' ),
						      'target' => 'cinematic_product_options',
						      'class'  => 'show_if_cinematic',
						     );
    	return $tabs;
  }
  
 
  public function avclwpc_load_cinematic_class($php_classname, $product_type ){

  		if ( $product_type == 'cinematic' ) {
			$php_classname = 'WC_Product_Cinematic';
		}
	  
	return $php_classname;
  }
  public function avclwpc_cinematic_product_type_content(){

	 global $post;
	 ?><div id='cinematic_product_options' class='panel woocommerce_options_panel'>
     <div class='options_group'>
	 
 <?php
	 
	$options=[];
    $id = $post->ID;

    $get_selected_builder=get_post_meta( $id, 'avclwpc_selected_builder_in_product_page', true );
    
    if (is_serialized( $get_selected_builder)) {
    	 $get_selected_builder=unserialize($get_selected_builder);
    }

    $get_all_builders=get_posts(array(
				    'post_type'   => 'avcl_events',
				    'post_status' => 'publish',
				    'posts_per_page' => -1,
				    				    
				    ));


		$options[0]=__('None','avclwpcl');
			
		foreach ($get_all_builders as $index => $post) {
			
						$options[$post->ID]=__($post->post_title,'avclwpcl');
		}		
						
	    woocommerce_wp_select(
			array(
			  'id' => 'avclwpc_cinematic_product_select_builder',
			  'label' => __( 'Select Builder', 'avclwpcl' ),
			  'selected' => true,
        	  'value'    => ( empty($get_selected_builder) && empty($last_key) ? 0 : $get_selected_builder['selected_theater']),
	          'options' => $options
			)
	    );
	    
	    include_once(dirname(__FILE__).'/view/single_product_loaded_selector.php');
	   

		
 ?></div>
 </div><?php
  }
  
  public function avclwpc_product_page_display_event_setup(){
 	
	 	 $status=[];
		 $builder_id=(int)$_POST['id'];
		 $current_product_id=(int)$_POST['current_product_id'];

		 if (empty($builder_id) && !is_int($builder_id)) {
		 	$status['error']='ID Not Found';
		 	 
		 }else{
		 	    $builder_data= get_post_meta( $builder_id,  'avclwpcb_builder_data', true );
		 	 	include_once(dirname(__FILE__).'/view/selector_ajax_in_product_page.php' );
		 }

	 	echo json_encode($status);
	  	wp_die();
  }
  public function avclwpc_save_cinematic_product_type_content($post_id){
 	
        if (empty($post_id) && !avclwpc_validateInteger($post_id) ) {
        	return false;
        }
	
        $new_array=[];
        $_saved=[];
      	
	  	if (isset($_POST['avclwpc_cinematic_product_select_builder'])) {

	  		$selected_builder_id=(int)$_POST['avclwpc_cinematic_product_select_builder'];
	  		
	  		if (!empty($selected_builder_id) &&  avclwpc_validateInteger($selected_builder_id)) {

	  			if (isset($_POST['avclwpc_event_details'])) {
	  				$details=avclwpc_sanitize_array($_POST['avclwpc_event_details']);

	  				$details['selected_theater']=(int)$_POST['avclwpc_cinematic_product_select_builder'];
	  				
	  			}
	  		}else{
	  			return false;
	  		}
          
	  		update_post_meta( $post_id, 'avclwpc_selected_builder_in_product_page', $details );
	  	}

  	}

  	public function avclwpc_know_woo_currency_set_status(){
  		
	 	global $pagenow;

	 	$curreny=get_option('woocommerce_currency');
	   
	    if ( empty($curreny) && $pagenow == 'post.php' ) {
	    	 
	    	 new avclwpc_throw_messages('AVCL Theater Builder - Hey! It\'s Seems Like The Currency Of Woocommerce Is Not Set.','notice notice-warning is-dismissible');
		}
	}

	public function avclwpc_when_order_status_changed($id, $this_status_transition_from, $this_status_transition_to, $instance){
		
		global $wpdb;
		
		if ($this_status_transition_from == 'processing' && $this_status_transition_to == 'completed' || $this_status_transition_from == 'pending' && $this_status_transition_to == 'processing') {
			
		    $order = wc_get_order( $id );
		    $items = $order->get_items();

		 	foreach ( $items as $item ) {

		 		$item_id      = $item->get_id();
			    $product_name = $item->get_name();
			    $product_id   = $item->get_product_id();
			    $product      = $item->get_product();
			
			 	if ('cinematic' == $product->get_type()) {
				 	 
				 
			 	 	$get_seat_details=wc_get_order_item_meta( $item_id, 'avclwpc_booked_seats_details', true );

					if (is_serialized( $get_seat_details)) {
						$get_seat_details=unserialize($get_seat_details);
					}

				    $get_show_date=$get_seat_details['date'];
			    	$get_show_time=$get_seat_details['time'];
			    	$theater_id=$get_seat_details['theater_id'];
			    	unset($get_seat_details['date']);
			    	unset($get_seat_details['time']);
			    	unset($get_seat_details['theater_id']);
	         		
		         	$tablename = $wpdb->prefix.'avclwpc_order_details';

			        $wpdb->insert( $tablename, array(
			            'order_id' => $id, 
			            'item_id' => $product_id,
			            'booked_seats' => serialize($get_seat_details), 
			            'theater_id' =>$theater_id,
			            'show_date' => $get_show_date,
			            'show_time' => $get_show_time, 
			        ));
				}
			}
		}
	}
	
}
