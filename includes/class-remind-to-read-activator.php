<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/RemindToRead/wp-remind-to-read
 * @since      1.0.0
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/includes
 * @author     Leonard Bogdonoff <rememberlenny@gmail.com>
 */
class Remind_To_Read_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option("rtr-extended-settings", array(
			"remind_to_read_active"	=> !empty(REMIND_TO_READ_STATUS) ? REMIND_TO_READ_STATUS : "no",
			"remind_to_read_url"	=> !empty(REMIND_TO_READ_URL) ? REMIND_TO_READ_URL : "",
			"remind_to_read_key"	=> !empty(REMIND_TO_READ_KEY) ? REMIND_TO_READ_KEY : ""
		));
	}

}
