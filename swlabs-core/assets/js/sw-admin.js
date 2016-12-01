jQuery(document).ready(function($) {
	"use strict";

	//--------------Page template & mbox------------------
	// Show or hide metabox
	var shwPageTemplate = $("#page_template"),
		shwMboxes = $(".shw-mbox"),
		shwCurrent,
		shwTpValues = [];
	
	function shwShow(selected) {
		var active = ".shw-mbox-active-all";
		
		if (selected) {
			active += ",.shw-mbox-active-"+selected;
		}
		shwMboxes.parents(".postbox").hide();
		shwMboxes.filter(active).parents(".postbox").show();
	}
	function shwGetTpClass(template) {
		template = template.replace("page-templates/","");;
		return template.replace(".php","");
	}
	function shwGetTpValue(idx,el) {
		shwTpValues[idx]=shwGetTpClass($(el).attr("value"));
	}
	function shwTpChange(el) {
		var selected = shwGetTpClass(shwPageTemplate.val());
		if (selected != shwCurrent) {
			shwCurrent = selected;
			shwShow(selected);
		}
	}
	if (shwPageTemplate.length > 0) {
		shwPageTemplate
			.find("option")
			.each(shwGetTpValue)
			.end()
			.change(shwTpChange)
			.triggerHandler("change");
	}
	$(".shw-mbox-blog-column").change(function() {
		if( $(this).val() != '1') {
			$(".shw-mbox-blog-grid").show();
		} else {
			$(".shw-mbox-blog-grid").hide();
		}
		
	}).triggerHandler("change");
	
	//Select radio (image format)
	$('.shw-mbox-radio-row label').click(function() {
		$(this).parent().find('label').removeClass('shw-image-select-selected');
		$(this).addClass('shw-image-select-selected');
	});
	$('.shw-mbox-radio-row input').change(function() {
		if ($(this).is(':checked')) {
			$('label[for="' + $(this).attr('id') + '"]').click();
		}
	});
	// images in label ie fix
	$(document).on('click', 'label img', function() {
		$('#' + $(this).parents('label').attr('for')).click();
	});
	//Check box
	$('.shw-mbox-custom-bg-row input[type=checkbox]').click(function() {
		var divcolor = $(this).parent().parent().find('div');
		if ($(this).is(':checked')) {
			divcolor.removeClass('hide');
		} else {
			divcolor.addClass('hide');
		}
	});
	
	if(0 == $("#post-body-content > *").length) {
		$("#post-body-content").hide();
	}

	//  Tab Panel in page option
	$('.tab-list a').on('click', function(e){
		e.preventDefault();
		var tab_id = $(this).attr('href');
		var tab_content = $(this).parents('.tab-panel').find('.tab-container ' + '#' + tab_id);

		$(this).parents('.tab-list').find('li').removeClass('active');
		$(this).parent().addClass('active');

		$(this).parents('.tab-panel').find('.tab-container .tab-content.active').hide();
		tab_content.fadeIn().addClass('active');
	});
	// display / hide when default setting checkbox checked
	$('.shw-footer-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_footer_option").addClass('hide');
		} else {
			$("#div_shw_footer_option").removeClass('hide');
		}
	});
	$('.shw-sidebar-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_sidebar_option").addClass('hide');
		} else {
			$("#div_shw_sidebar_option").removeClass('hide');
		}
	});
	$('.shw-general-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_general_option").addClass('hide');
		} else {
			$("#div_shw_general_option").removeClass('hide');
		}
	});
	$('.shw-header-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_header_option").addClass('hide');
		} else {
			$("#div_shw_header_option").removeClass('hide');
		}
	});
	$('.shw-page-title-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_page_title_option").addClass('hide');
		} else {
			$("#div_shw_page_title_option").removeClass('hide');
		}
	});
	$('.shw-post-option').live('click', function(){
		if ($(this).is(':checked')) {
			$("#div_shw_post_option").addClass('hide');
		} else {
			$("#div_shw_post_option").removeClass('hide');
		}
	});
	//--------------End page template & mbox------- 
	//--------------Pricing Table------------------
	var shwPricingTable     = $(".shw-pricing-table"),
		shwPricingItemDel   = $(".shw-custom-meta .pricing-item-remove"),
		shwPricingItemAdd   = $(".shw-custom-meta .pricing-item-add"),
		shwPricingItemClone = $(".shw-pricing-item-clone"),
		shwPricingAddRow    = $(".shw-custom-meta .pricing-row-add"),
		shwPricingDelRow    = $(".shw-custom-meta .pricing-row-remove"),
		shwPricingRowClone  = $(".shw-pricing-row-clone"),
		shwHidPricingItem   = $("#shw_hid_pricing_item");
	
	// Del Pricing Item
	shwPricingItemDel.live('click', function() {
		$(this).parent().remove();
	});
	// Add Pricing Item
	shwPricingItemAdd.live('click', function() {
		var regEx  = new RegExp("pricing_item","g"),
			itemID,
			itemName,
			newItem;
		itemID = jQuery.fn.swlabsCom.cnvInt( $(this).attr("data-item") ) + 1;
		// change item name
		newItem = shwPricingItemClone.html().replace( regEx, itemID );
		// change item id
		regEx = new RegExp("shw_pricing_meta_id","g");
		newItem = newItem.replace( regEx, "shw_pricing_meta_"+itemID );
		shwPricingTable.append(newItem);
		$(this).attr("data-item", itemID);
		// reload meta color
		shwPricingTable.find(".shw-color").addClass( jQuery.fn.swlabsCom.colorCss );
		jQuery.fn.swlabsCom.reloadMetaColor();
		
	});
	
	//video post type
	$("#swlabscore_mbox_video_type").change(function(){
		if ( $(this).val() === 'vimeo'){
			$(this).parents('.shw-video-meta').find('.vimeo-id').addClass('active');
			$(this).parents('.shw-video-meta').find('.video_upload').removeClass('active');
			$(this).parents('.shw-video-meta').find('.youtube-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').addClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').find('.hide-control').addClass('hide');
		}
		else if ( $(this).val() === 'youtube'){
			$(this).parents('.shw-video-meta').find('.youtube-id').addClass('active');
			$(this).parents('.shw-video-meta').find('.video_upload').removeClass('active');
			$(this).parents('.shw-video-meta').find('.vimeo-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').addClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').find('.hide-control').removeClass('hide');
		}
		else if( $(this).val() === 'video-upload'){
			$(this).parents('.shw-video-meta').find('.video_upload').addClass('active');
			$(this).parents('.shw-video-meta').find('.vimeo-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.youtube-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').addClass('active');
		}
		else{
			$(this).parents('.shw-video-meta').find('.vimeo-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.youtube-id').removeClass('active');
			$(this).parents('.shw-video-meta').find('.video_upload').removeClass('active');
			$(this).parents('.shw-video-meta').find('.video-option').removeClass('active');
		}
	})
	
	if($('.shw_upload_button').length ) {
		window.uploadfield = '';
		$('.shw_upload_button').live('click', function() {
			window.uploadfield = $('.textbox-url-video', $(this).parents( '.upload' ));
			tb_show('Upload', 'media-upload.php?type=image&TB_iframe=true', false);
			return false;
		});
		window.send_to_editor_backup = window.send_to_editor;
		window.send_to_editor = function(html) {
			if(window.uploadfield) {
				if($('img', html).length >= 1) {
					var image_url = $('img', html).attr('src');
				} else {
					var image_url = $($(html)[0]).attr('href');
				}
				$(window.uploadfield).val(image_url);
				window.uploadfield = '';
				tb_remove();
			} else {
				window.send_to_editor_backup(html);
			}
		}
	}
	//upload video in post and post type video
	if ( $('#swlabscore_mbox_video_type').val() === 'video-upload' ){
		$('.shw-video-meta').find('.video_upload').addClass('active');
	}

	jQuery('.td-progress-show-details').click(function(){
		jQuery(this).hide();
		jQuery('div.td-demo-msg').show('fast', function() {
		});
	});
});