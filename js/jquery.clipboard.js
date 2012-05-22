/**
 * Clipboard
 * A jQuery plugin for implementing "click to clipboard" functionality
 * 
 * Version 0.5
 * Author: Chris Patterson
 *
 * License: GPL 3 http://www.gnu.org/licenses/gpl-3.0.html
 * 
 * Inspired by:
 * ClipboardCopy (http://www.jeffothy.com/weblog/clipboard-copy/)
 * Skitch (http://skitch.com)
 * 
 * NOTE: this plugin depends upon jquery.flash.js
 *
 * ASSUMPTION: All elements which will have "click to clipboard" associated will need an id attribute
 * Additionally, all elements which will be the target for insertion will need an id attribute
 *
 * [TODO]
 * - consolidate current duped insert / timeout functions for the hasFlash / noFlash conditionals
 * - allow customization of the element wrapping the clipboardText
 * - (Possible) look at adding better noFlash clipboard support. Currently, we only support IE,
 * as Opera / Mozilla were behaving wonkily in early testing of createTextRange support.
 **/
(function($){
	$.fn.clickToClipboard = function(options) {
		
	var defaults = {
		fadeoutLength: 600,
		fadeoutTimer: 1000,
		clipboardText: 'Copied to Clipboard',
		clipboardTextInsert: 'after' /* Allowed values: "before" "after" */
	};
	
	var options = $.extend(defaults, options);
	
	var hasFlash = $(document).flash.hasFlash(7);
	var insertText = '<span class="copied-to-clipboard" style="opacity: 0.999999; display: none;">' + options.clipboardText + '</span>';
		
		return this.each(function() {
			(options.clipboardTextInsert == "before") ? $(insertText).insertBefore(this) : $(insertText).insertAfter(this);
			
			if (hasFlash) {
				if(!($('div.flashcopier').length > 0)) { $('<div class="flashcopier">').appendTo('body');}
				$( this ).bind (
					"click",
					function(){
						var obj = $(this);
						$('.flashcopier').flash({ src: '_clipboard.swf', width: 0, height: 0, flashvars: {clipboard: obj.val()} }, { update: false });
						(options.clipboardTextInsert == "before") ? obj.prev('.copied-to-clipboard:first').show() :	obj.next('.copied-to-clipboard:first').show();		
						(options.clipboardTextInsert == "before") ? setTimeout("$('#" + obj.attr("id")+"').prev('.copied-to-clipboard:first').fadeOut(" + options.fadeoutLength + ")", options.fadeoutTimer) : setTimeout("$('#" + obj.attr("id")+"').next('.copied-to-clipboard:first').fadeOut(" + options.fadeoutLength + ")", options.fadeoutTimer);			
						this.blur();
					}
				);
			}
		});
	};

})(jQuery);
