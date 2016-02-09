jQuery(document).ready(function($) {

	var message = passedFromServer.jsWarningHtml;

	function postTypeSupportsFeaturedImage() {
		return $.find('#postimagediv').length !== 0;
	}

	function shouldBlockPublishUpdateMessage() {
		var $img = $('#postimagediv').find('img');
		if ($img.length === 0) {
			message = passedFromServer.jsWarningHtml;
			return true;
		}
		if (passedImageIsTooSmall($img)) {
			message = passedFromServer.jsSmallHtml;
			return true;
		}
		return false;
	}

	function passedImageIsTooSmall($img) {
		var input = $img[0].src;
		var pathToImage = input.replace(/-\d+[Xx]\d+\./g, ".");
		console.log(pathToImage);
		var featuredImage = new Image();
		featuredImage.src = pathToImage;
		return featuredImage.width < passedFromServer.width || featuredImage.height < passedFromServer.height;
	}

	function publishButtonIsPublishText() {
		return $('#publish').attr('name') === 'publish';
	}

	function disablePublishAndWarn() {
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
			if (shouldBlockPublishUpdateMessage() && publishButtonIsPublishText()) {
				disablePublishAndWarn();
			} else {
				clearWarningAndEnablePublish();
			}
		}
	}

	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 3000);
});
