<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/RemindToRead/wp-remind-to-read
 * @since      1.0.0
 *
 * @package    Remind_To_read
 * @subpackage Remind_To_read/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="sendlater-move-right">
  <div class="sendlater-container accept-email">
    <div class="sendlater-button">
      <button style=""><span class="con-clock"></span>Need to stop reading?</button>
    </div>
    <a href="#" class="close-icon"></a>
    <div class="sendlater-email-input">
      <form action="" class="sll-email-form row" style="">
        <div class="sendlater-email-field-wrapper">
          <input name="email" type="email" required="" placeholder="Enter your email address" class="sendlater-email-input-field sll-email">
        </div>
        <div class="sendlater-email-button-wrapper">
          <input type="submit" value="Go" class="email-input-submit col c3">
        </div>
      </form>
      <p class="email-more-explain-after">We'll send you a reminder of where you left off.</p>
    </div>
    <div class="sendlater-time-option">
      <p>Your reminder will be sent 
        <select class="time-option-change time-option-change-options" style="width: auto;">
          <option value="2 hours" class="visible">in 2 hours</option>
          <option value="1 minute">now</option>
          <option value="4 hours">in 4 hours</option>
          <option value="24 hours">tomorrow</option>
          <option value="72 hours">in 3 days</option>
        </select>
      </p>
    </div>
  </div>
</div>
