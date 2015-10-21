(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

	 // _exists
	 // _last_updated
	 // _last_depth
	 // _page_height
	 // _page_width

	var RemindToRead = RemindToRead || {
		exists: 			false,
		uid: 					null,
		last_updated: null,
		last_depth: 	null,
		page_height: 	null,
		page_width: 	null
	};

	RemindToRead.blastOff = function(){
	  console.log('Working');
	  this.getUID();
		this.checkLocalStorage();
	  if ( this.exists != false ){
	  	this.getLastSettings();
	  	this.promptOffer();
	  }
	}


	RemindToRead.getUID = function(){
		var len = location.href.length;
		var beg = location.host.slice(0,3);
		var end = location.href.slice(len-3, len);
		this.uid = beg + len + end;
	}

	RemindToRead.checkLocalStorage = function(){
	  if( localStorage.getItem(this.uid + '_exists') != null ){
		  this.exist = true;
	  }
	}

	RemindToRead.getLastSettings = function(){
		var u = this.uid;
		this.last_updated = localStorage.getItem(u + '_last_updated');
		this.last_depth 	= localStorage.getItem(u + '_last_depth');
		this.page_height 	= localStorage.getItem(u + '_page_height');
		this.page_width 	= localStorage.getItem(u + '_page_width');
	}

	RemindToRead.promptOffer = function(){
		// Create the template and display
		$('').on('click', function(){
			this.moveToSavedSpot();
		})
	}

	RemindToRead.moveToSavedSpot = function(){}

	$(document).on('load', function(){
	  RemindToRead.blastOff();
	});



})( jQuery );
