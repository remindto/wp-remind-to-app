<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/RemindToRead/wp-remind-to-read
 * @since      1.0.0
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/public
 * @author     Leonard Bogdonoff <rememberlenny@gmail.com>
 */
class Remind_To_Read_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $remind_to_read    The ID of this plugin.
	 */
	private $remind_to_read;

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
	 * @param      string    $remind_to_read       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $remind_to_read, $version ) {

		$this->remind_to_read = $remind_to_read;
		$this->version = $version;

		add_action( 'wp_head', array( $this, 'healthcheck_remind_to_read') );
		// add_action( 'wp_ajax_remind_to_read', array( $this, 'remind_to_read') );
		add_action( 'wp_ajax_nopriv_remind_to_read', array( $this, 'remind_to_read') );
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
		 * defined in Remind_To_Read_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Remind_To_Read_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'css/remind-to-read-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Remind_To_Read_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Remind_To_Read_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'js/remind-to-read-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'js/continue-to-read-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'js/uturn-public.js', array( 'jquery' ), $this->version, false );

	}


	public function healthcheck_remind_to_read() {
		error_log('Remind to read is working');
	}

	/**
	 * Response from AJAX request from frontend
	 */
	public function remind_to_read() {
	    if ( isset($_REQUEST))  {
	      $length 			= isset( $_REQUEST['length'] ) 			? htmlspecialchars($_REQUEST['length']) 		: null;
	      $email 			= isset( $_REQUEST['email'] ) 			? htmlspecialchars($_REQUEST['email']) 			: null;
	      $url 				= isset( $_REQUEST['url'] ) 			? htmlspecialchars($_REQUEST['url']) 			: null;
	      $selector 		= isset( $_REQUEST['selector'] ) 		? htmlspecialchars($_REQUEST['selector']) 		: null;
	      $content 			= isset( $_REQUEST['content'] ) 		? htmlspecialchars($_REQUEST['content']) 		: null;
	      $selectorIndex 	= isset( $_REQUEST['selectorIndex'] ) 	? htmlspecialchars($_REQUEST['selectorIndex']) 	: null;
	      $json = array(
	        'email'   			=> $email,
	        'length'  			=> $length,
	        'url'     			=> $url,
	        'selector'    		=> $selector,
	        'content'     		=> $content,
	        'selectorIndex'   	=> $selectorIndex,
	      );
	      echo json_encode($json);
	    }
	    $this->make_remind_request($json);

	    die();
	}
	 
	/**
	 * Request made to external saving service
	 */
	public function make_remind_request($obj){
	    $rtrsettings = $this->rtr_ext_settings();
	    $rtr_url = $rtrsettings['remind_to_read_url'];
	    $rtr_key = $rtrsettings['remind_to_read_key'];
	    if( empty($rtr_url) || empty($rtr_key) ){
	    	error_log('$rtrsettings missing.');
	    	return false;
	    }
	    $domain = $rtrsettings['remind_to_read_url'] . $rtrsettings['remind_to_read_key'] . '/later/new';
	    $url =  '' .
				$domain .
				'?' .
				'url=' . $obj['url'] .
				'&' .
				'delay=' . $obj['length'] .
				'&' .
				'email=' . $obj['email'] .
				'&' .
				'selector=' . $obj['selector'] .
				'&' .
				'content=' . $obj['content'] .
				'&' .
				'selectorIndex=' . $obj['selectorIndex'] .
				'&' .

				'renew=' . 'true'; 

	    $response = wp_remote_get( $url );
	}

	public function rtr_ext_settings() {

		$settings = array();

		$settings["remind_to_read_active"]  = "no";
		$settings["remind_to_read_url"]  	= "";
		$settings["remind_to_read_key"]  	= "";

		$rtr_ext_settings = Remind_To_Read_Admin::rtr_get_extended_settings();

		/* Remind To Read */
		$settings["remind_to_read_active"] 	= isset( $rtr_ext_settings["remind_to_read_active"] ) 	? $rtr_ext_settings["remind_to_read_active"] : '';
		$settings["remind_to_read_url"] 	= isset( $rtr_ext_settings["remind_to_read_url"] ) 		? $rtr_ext_settings["remind_to_read_url"] : '';
		$settings["remind_to_read_key"] 	= isset( $rtr_ext_settings["remind_to_read_key"] ) 		? $rtr_ext_settings["remind_to_read_key"] : '';

		return apply_filters( 'rtr_ext_settings', $settings );
	}


}
