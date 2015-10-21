<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/RemindToRead/wp-remind-to-read
 * @since      1.0.0
 *
 * @package    Remind_To_Read
 * @subpackage Remind_To_Read/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<style>
    .success {
		padding:       0.8em;
		margin-bottom: 1em;
		border:        2px solid #ddd;
		background:    #e6efc2;
		color:         #264409;
		border-color:  #c6d880;
	}

    .success a {
		color:         #264409;
	}

    .success p {
		margin:         0;
	}

    .wp-rtr-extended-light {
		color:          #777;
		font-size:      12px;
		margin-left:     1em;
	}
	.noUnderline {
		text-decoration: none;
	}

	#rtr-extended-settings .form-table th {
		width: 230px;
	}
</style>

<div class="wrap" id="rtr-extended-settings">
    <?php
    if (!empty($errors)) {
        foreach($errors as $error) {
            $this->printErrorMessage($error);
        }
    }
    ?>
    <h2>RTR Extended Settings <span class="wp-rtr-extended-light">Version <?php echo Remind_To_Read_Admin::$VERSION; ?></span></h2>


    <?php
    if ($isSaved) {
        $this->printSuccessMessage("Settings saved successfully.");
    }
    ?>
    <form name="rtr-extended-settings" method="post" action="">

      <input type="hidden" name="isRTRExtSettings" value="Y" />
	<hr>
      <h3>'Remind to Read' Module</h3>
      <table class="form-table">
        <tr valign="top">
          <th scope="row"><label for="module_remind_to_read_active"><?php _e('Remind to Read Status'); ?></label></th>
          <td>
            <?php $this->printSelectTag("remind_to_read_active",
            array("yes" => "Active", "no" => "Disabled"),
            $options["remind_to_read_active"]
            ); ?>
          </td>
        </tr>
      </table>

      <p class="submit">
        <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
      </p>
    </form>
</div>
