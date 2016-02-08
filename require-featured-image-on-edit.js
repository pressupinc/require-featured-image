jQuery(document).ready(function($) {

	function postTypeSupportsFeaturedImage() {
		return $.find('#postimagediv').length !== 0;
	}

	function lacksFeaturedImage() {
		return $('#postimagediv').find('img').length === 0;
	}

	function imageIsTooSmall() {
		var $img = $('#postimagediv').find('img');
		var regex = /-\d+[Xx]\d+\./g;
		var input = $img[0].src;
		var pathToImage = input.replace(regex, ".");

		var featuredImage = new Image();
		featuredImage.src = pathToImage;

		return featuredImage.width < passedFromServer.width || featuredImage.height < passedFromServer.height;
	}

	function publishButtonIsPublishText() {
		return $('#publish').attr('name') === 'publish';
	}

	function disablePublishAndWarn(reason) {
		if (reason == 'none') {
			var message = passedFromServer.jsWarningHtml;
		} else {
			var message = passedFromServer.jsSmallHtml;
		}
		createMessageAreaIfNeeded();
		$('#nofeature-message').addClass("error")
			.html('<p>'+message+'</p>');
		$('#publish').attr('disabled','disabled');
	}

	function clearWarningAndEnablePublish() {
		$('#nofeature-message').remove();
		$('#publish').removeAttr('disabled');
	}

	function createMessageAreaIfNeeded() {
		if ($('body').find("#nofeature-message").length === 0) {
			$('#post').before('<div id="nofeature-message"></div>');
	    }
	}

    function detectWarnFeaturedImage() {
		if (postTypeSupportsFeaturedImage()) {
			if (lacksFeaturedImage() && publishButtonIsPublishText()) {
				disablePublishAndWarn( 'none' );
			} else if (imageIsTooSmall() && publishButtonIsPublishText()) {
				disablePublishAndWarn( 'too-small' );
			} else {
				clearWarningAndEnablePublish();
			}
		}
	}

	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 3000);
});
