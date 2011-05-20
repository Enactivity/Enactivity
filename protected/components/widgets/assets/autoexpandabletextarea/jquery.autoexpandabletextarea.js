/**
 * jQuery Auto Expandable TextArea plugin file.
 *
 * @author Ajay Sharma
 */

;(function($) {
	
	/**
	 * Resize a textarea
	 * Invoke via jQuery('#textAreaId').autoExpandableTextArea(encodedOptions);
	 */
	$.fn.autoExpandableTextArea = function(options) {
		// load options into settings var
		var settings = jQuery.extend({
			// set option defaults here as
			// optionName: optionValue
			minimumRows: 1,
			maximumRows: 5
		}, options);
		
		//'this' refers to the text area
		$(this).keyup(function() {
			var textAreaVerticalLength = this.value.length;
			var textAreaHorizontalLength = this.offsetWidth;
			if (textAreaVerticalLength != this.valLength || textAreaHorizontalLength != this.boxWidth) {
				if (hCheck && (textAreaVerticalLength < this.valLength || textAreaHorizontalLength != this.boxWidth)) this.style.height = "0px";
				var h = Math.max(this.expandMin, Math.min(this.scrollHeight, this.expandMax));
				this.style.overflow = (this.scrollHeight > h ? "auto" : "hidden");
				this.style.height = h + "px";
				this.valLength = textAreaVerticalLength;
				this.boxWidth = textAreaHorizontalLength;
			}
			return true;
		});
		
		return this;
	};

})(jQuery);