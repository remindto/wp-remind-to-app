<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://remindtoread.com
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

		wp_enqueue_style( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

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

		wp_enqueue_script( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}

}
