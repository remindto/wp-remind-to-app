<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/RemindToRead/wp-remind-to-read
 * @since      1.0.0
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/admin
 * @author     Leonard Bogdonoff <rememberlenny@gmail.com>
 */
class Remind_To_Read_Admin {

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

	public static $VERSION		= "1.0.0";
	private $NAME;
	private $MENU_SLUG			= "rtr-extended-settings";
	private $MENU_TITLE			= "Remind to Read Settings";
	private $MENU_PAGE_TITLE	= "Remind to Read Settings > Settings";
	private $OPTIONS_KEY		= "rtr-extended-settings";
	private $CAPABILITY			= "manage_options";

	private $OPTION_DEFAULTS	= array(
		"remind_to_read_active" => "no",
		"remind_to_read_url" 	=> "",
		"remind_to_read_key" 	=> ""
	);

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $remind_to_read       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $remind_to_read, $version ) {

		$this->remind_to_read = $remind_to_read;
		$this->version = $version;

		$this->RTRExtendedSettings();
		
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
		 * defined in Remind_To_Read_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Remind_To_Read_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'css/remind-to-read-admin.css', array(), $this->version, 'all' );

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
		 * defined in Remind_To_Read_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Remind_To_Read_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->remind_to_read, plugin_dir_url( __FILE__ ) . 'js/remind-to-read-admin.js', array( 'jquery' ), $this->version, false );

	}


	public static function rtr_get_extended_settings() {

		$options = get_option("rtr-extended-settings");
		$results = array();

		if (isset($options["remind_to_read_active"])) {
			$results["remind_to_read_active"] = $options["remind_to_read_active"];
		}

		if (isset($options["remind_to_read_url"])) {
			$results["remind_to_read_url"] = $options["remind_to_read_url"];
		}

		if (isset($options["remind_to_read_key"])) {
			$results["remind_to_read_key"] = $options["remind_to_read_key"];
		}

		return $results;
	}


	public function RTRExtendedSettings() {
		add_action('admin_menu',   array(&$this, 'addSettingsSubMenu'));
	}

	/**
	* Settings
	*/
	public function displaySettings() {
		if (!current_user_can($this->CAPABILITY)) {
		}

		$errors  = array();
		$isSaved = false;
		$options = $this->getOptions();

		if (isset($_POST["isRTRExtSettings"]) && $_POST["isRTRExtSettings"] == 'Y') {

			if (empty($_POST["remind_to_read_active"])) {
				array_push($errors, "Remind to read status needs to be set.");
			} else {
				$options["remind_to_read_active"] = sanitize_text_field($_POST["remind_to_read_active"]);
			}


			if (empty($_POST["remind_to_read_key"])) {
				array_push($errors, "Remind to read key needs to be set.");
			} else {
				$options["remind_to_read_key"] = sanitize_text_field($_POST["remind_to_read_key"]);
			}


			if (empty($_POST["remind_to_read_url"])) {
				array_push($errors, "Remind to read domain needs to be set.");
			} else {
				$options["remind_to_read_url"] = sanitize_text_field($_POST["remind_to_read_url"]);
			}

			if (empty($errors)) {
				update_option($this->OPTIONS_KEY, $options);
				$isSaved = true;
			}
		}
		include("partials/remind-to-read-admin-display.php");
	}

	/**
	* Add settings page in WordPress Settings menu.
	*/
	public function addSettingsSubMenu() {
		add_options_page($this->MENU_PAGE_TITLE,
						 $this->MENU_TITLE,
						 $this->CAPABILITY,
						 $this->MENU_SLUG,
						 array(&$this, 'displaySettings'));
	}

	/**
	* Adds a 'Settings' link to the Plugins screen in WP admin
	*/
	public function addPluginMetaLinks($links) {
		array_unshift($links, '<a href="'. $this->getSettingsURL() . '">' . __('Settings'));
		return $links;
	}

	/**
	* Show warning if not properly setup yet
	*/
	public function displayAdminWarning() {
		$options = $this->getOptions();
		if (!isset($options['api_key']) || empty($options['api_key'])) {
			?>
			<div id='message' class='error'>
				<p><strong>Remind to Read Settings plugin is not active.</strong> You need to <a href='<?php echo $this->getSettingsURL(); ?>'>update settings</a> to get things going.</p>
			</div>
			<?php
		}
	}

	/**
	* Get the URL of the plugin settings page
	*/
	private function getSettingsURL() {
		return admin_url('options-general.php?page=' . $this->MENU_SLUG);
	}

	/**
	* Returns options
	*/
	private function getOptions() {
		$options = get_option($this->OPTIONS_KEY);
		if ($options === false) {
			$options = $this->OPTION_DEFAULTS;
		} else {
			$options = array_merge($this->OPTION_DEFAULTS, $options);
		}
		return $options;
	}

	public function printSuccessMessage($message) {
		?>
		<div class='success'><p><strong><?php print esc_html($message); ?></strong></p></div>
		<?php
	}

	public function printErrorMessage($message) {
		?>
		<div id='message' class='error'><p><strong><?php print esc_html($message); ?></strong></p></div>
		<?php
	}

	public function printSelectTag($name, $options, $selectedOption="") {
		$tag = '<select name="' . esc_attr($name) . '" id="' . esc_attr($name) . '">';
		foreach ($options as $key => $val) {
			$tag .= '<option value="' . esc_attr($key) . '"';
			if ($selectedOption == $key) { $tag .= ' selected="selected"'; }
			$tag .= '>'. esc_html($val) . '</option>';
		}
		$tag .= '</select>';
		print $tag;
	}

	public function printTextTag($name, $value, $options=array()) {
		$tag = '<input type="text" name="' . esc_attr($name). '" id="' . esc_attr($name) . '" value="' . esc_attr($value) . '"';
		foreach ($options as $key => $val) {
			$tag .= ' ' . esc_attr($key) . '="' . esc_attr($val) . '"';
		}
		$tag .= ' />';
		print $tag;
	}

	public function printTextareaTag($name, $value) {
		$tag = '<textarea name="' . esc_attr($name). '" id="' . esc_attr($name) . '">' . stripslashes($value). '</textarea>';
		print $tag; // $tag;
	}

}
