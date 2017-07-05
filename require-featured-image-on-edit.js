jQuery(document).ready(function($) {

	function checkImageReturnWarningMessageOrEmpty() {
		var $img = $('#postimagediv').find('img');
		if ($img.length === 0) {
			return passedFromServer.jsWarningHtml;
		}
		if (passedImageIsTooSmall($img)) {
			return passedFromServer.jsSmallHtml;
		}
		return '';
	}

	function passedImageIsTooSmall($img) {
		var pathToImage = $img.data('rfiimgsrc');
		if (!pathToImage) {
			var input = $img[0].src;
			pathToImage = input.replace(/-\d+[Xx]\d+\./g, ".");
		}
		var featuredImage = new Image();
		featuredImage.src = pathToImage;
		return featuredImage.width < passedFromServer.width || featuredImage.height < passedFromServer.height;
	}

	function disablePublishAndWarn(message) {
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
		if (checkImageReturnWarningMessageOrEmpty()) {
			disablePublishAndWarn(checkImageReturnWarningMessageOrEmpty());
		} else {
			clearWarningAndEnablePublish();
		}
	}

	detectWarnFeaturedImage();
	setInterval(detectWarnFeaturedImage, 800);

});
