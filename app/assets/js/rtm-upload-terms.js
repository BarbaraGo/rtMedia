// check for terms and condition

/**
 * Remove Terms Warning Popup,
 * Add Warning Message Before Submit Button
 * By: Malav Vasita <malav.vasita@rtcamp.com>
 */
if (typeof rtMediaHook == 'object') {
	rtMediaHook.register('rtmedia_js_upload_file', function (args) {
		if (args == false)
		{
			return args;
		}

		var rt_alert_msg = ( ( typeof rtmedia_upload_terms_check_terms_message ) == "string" ) ? rtmedia_upload_terms_check_terms_message : rtmedia_upload_terms_check_terms_default_message;

		if (jQuery('#rtmedia_upload_terms_conditions').length > 0)
		{
			if (!jQuery('#rtmedia_upload_terms_conditions').is(':checked'))
			{
				//typeof rtmedia_gallery_action_alert_message != 'undefined' ? rtmedia_gallery_action_alert_message(rt_alert_msg, 'warning') : alert(rt_alert_msg);
				var selector = jQuery( '.rtmedia-upload-terms' );
				rtp_display_terms_warning ( selector, rt_alert_msg );
				return false;
			}
		}

		return true;
	});

	rtMediaHook.register('rtmedia_js_before_activity_added', function (args) {
		if ( typeof event !== typeof undefined && typeof event.target !== typeof undefined ) {
		  if ( jQuery(event.target).attr('id') == 'aw-whats-new-submit' )
			{
			   if (jQuery('#rtmedia_upload_terms_conditions').length > 0)
			   {
					if (args == false) {
						return args;
					}

					var rt_alert_msg = ( ( typeof rtmedia_upload_terms_check_terms_message ) == "string" ) ? rtmedia_upload_terms_check_terms_message : rtmedia_upload_terms_check_terms_default_message;
					if (!jQuery('#rtmedia_upload_terms_conditions').is(':checked')) {
						//typeof rtmedia_gallery_action_alert_message != 'undefined' ? rtmedia_gallery_action_alert_message(rt_alert_msg, 'warning') : alert(rt_alert_msg);
						var selector = jQuery( '.rtmedia-upload-terms' );
						rtp_display_terms_warning ( selector, rt_alert_msg );
						return false;
					}
				}
			}
		}
		return true;
	});

	/*rtMediaHook.register('rtmedia_js_after_activity_added', function () {
		if (jQuery('#rtmedia_upload_terms_conditions').length > 0) {
			jQuery('#rtmedia_upload_terms_conditions').removeAttr('checked');
		}
	});*/

	/**
	 * When Select Attribute for media [ rtmedia-custom-attributes: Add-Ons ] Issue:8,
	 * This Hook returns false that's why the attributes were not saved,
	 * Added: 'return true;'
	 * By: Yahil
	 */
	rtMediaHook.register('rtmedia_js_after_file_upload', function (up, file, resp) {

		if (jQuery('#rtmedia-upload-container #rtmedia_upload_terms_conditions').length > 0) {
			jQuery('#rtmedia_upload_terms_conditions').removeAttr('checked');
		}
		return true;
	});
}

jQuery(document).ready(function () {
	if( ( '#aw-whats-new-submit' ).length > 0 ) {
		$( '#aw-whats-new-submit' ).attr( 'disabled', 'disabled' );
	}
	
	jQuery( '#rtmedia_upload_terms_conditions' ).on( 'click', function () {
		if($( '#rtmedia_upload_terms_conditions' ).length > 0){
			$( '#rtmedia_upload_terms_conditions' ).change(function(){
				if ( $( '#rtmedia_upload_terms_conditions' ).is( ':checked' ) ){
						$( '#aw-whats-new-submit' ).attr( 'disabled', false );
				} else {
					$('#aw-whats-new-submit').attr( 'disabled', true );
				}
			});
		}

		if ( jQuery('#rtmedia_upload_terms_conditions').is(':checked') ) {
			jQuery('.rt_alert_msg').remove();
		} else {
			var selector = jQuery( '.rtmedia-upload-terms' );
			var rt_alert_msg = ( ( typeof rtmedia_upload_terms_check_terms_message ) == "string" ) ? rtmedia_upload_terms_check_terms_message : rtmedia_upload_terms_check_terms_default_message;
			rtp_display_terms_warning ( selector, rt_alert_msg );
		}

		if (typeof rtmedia_direct_upload_enabled != 'undefined' && rtmedia_direct_upload_enabled == '1') {
			if (jQuery('#aw-whats-new-submit').length > 0) {
				if (jQuery('#whats-new').val() != '' || jQuery('#rtmedia_uploader_filelist').children('li').length > 0) {
					jQuery('#aw-whats-new-submit').trigger('click');
				}
			} else {
				jQuery('.start-media-upload').trigger('click');
			}
		}
	});

});

function rtp_display_terms_warning ( selector, rt_alert_msg ) {
	if ( ! jQuery( '.rt_alert_msg' ).length ) {
	   selector.after('<span class="rt_alert_msg" style="color:red; display:block; clear:both;"> ' + rt_alert_msg + ' </span>');
	}
}
