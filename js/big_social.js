/**
 * Social Sharing Buttons.
 */
var popupCenter = function(url, title, w, h) {
  // Fixes dual-screen position                         Most browsers      Firefox
  var dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
  var dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

  var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
  var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

  var left = ((width / 2) - (w / 2)) + dualScreenLeft;
  var top = ((height / 3) - (h / 3)) + dualScreenTop;

  var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

  // Puts focus on the newWindow
  if (window.focus) {
    newWindow.focus();
  }
};

(function(jQuery) {
Drupal.behaviors.share_button_blocks = {
  attach: function (context, settings) {
	  	
	  	// check for svg support thank you css-tricks.com
		var supportsSvg = function() {
  		var div = document.createElement('div');
  			div.innerHTML = '<svg/>';
  		return (div.firstChild && div.firstChild.namespaceURI) == 'http://www.w3.org/2000/svg';
		};

		if (!supportsSvg()) {
  			document.documentElement.className += " bm-social-no-svg";
		} else {
			document.documentElement.className += " bm-social-svg";
		};
	  	// use bind for jquery 1.4.4
		jQuery('#bigSocialMediaShare a.popup', context).bind( 'click', function(e){
			var self = jQuery(this);
			popupCenter(self.attr('href'), self.find('.big_social-text').html(), 580, 470);
			e.preventDefault();
		});
		
		//Dismiss the buttons when --fixed and screen is larger than 768px
		// check it cuts the mustard first 
		if ('querySelector' in document && 'localStorage' in window && 'addEventListener' in window) {
		
		var getScreenWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
		var isFixedModifier = jQuery('#bigSocialMediaShare').hasClass('big-social-media--fixed');
		
		if (isFixedModifier && getScreenWidth >= 768) {

  		jQuery('#bigSocialMediaShare:not(.bound)', context).addClass('bound').append('<button class="js-big-social-media__dismiss"><span class="big-social-media__label">dismiss</span></button>');
		
		jQuery('#bigSocialMediaShare button', context).bind( "click", function(e) {
			jQuery('#bigSocialMediaShare .big-social-media__list').addClass('js-big-social-media__list');
			jQuery('#bigSocialMediaShare .big-social-media__list').toggleClass('is-closed');
			jQuery('#bigSocialMediaShare button').children().text('open');
			jQuery('#bigSocialMediaShare button').toggleClass('is-closed');
			e.stopPropagation();
		});
			
		}
		
    /* removed by SH
	jQuery('.big_social-item-list').css('margin-left', '-60px').delay(1000).animate({ marginLeft: "0"} , 200, 'swing');*/
	
		// end cut the mustard
		};
  }
};
})(jQuery);
