;(function($) {
	"use strict";
	$.fn.swlabsCom = function(){};
	var $this = $.fn.swlabsCom;
	$.fn.swlabsCom.colorCss = "sw-meta-color";

	// convert to int
	$.fn.swlabsCom.cnvInt = function( obj ) {
		var iVal = obj;
		if ( typeof iVal !== 'undefined' ) {
			iVal = parseInt( iVal, 10 );
		}
		if(isNaN(iVal)) {
			iVal = 0
		}
		return iVal;
	};
	$.fn.swlabsCom.reloadMetaColor = function( cls ) {
		if ( typeof cls == 'undefined' ) {
			cls = $.fn.swlabsCom.colorCss;
		}
		$("." + cls ).wpColorPicker();
	}

	$.fn.swlabsCom.shwProgressStep = function( step_to_percent ) {
		if (step_to_percent >= 100) {
			jQuery('#title_loading').hide();
			jQuery('#progress_loading').hide();
			jQuery('#content_loading').hide();

			jQuery('#title_success').show();
			jQuery('#content_success').show();
			jQuery('.td-progress-show-details').show();
		} else {
			jQuery('.td_progress_bar div').css('width', step_to_percent + '%');
		}
	}

	$.fn.swlabsCom.shwProgressError = function( ) {
		jQuery('#title_loading').hide();
		jQuery('#progress_bar').hide();
		jQuery('#title_error').show();
		jQuery('div.td-demo-msg').show();
	}
})(jQuery);