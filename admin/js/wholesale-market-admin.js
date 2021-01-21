(function ($) {
  "use strict";

  /**
   * All of the code for your admin-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */

  $(document).ready(function () {
    $("#wholesale_market_checkbox_inventory_setting").click(function () {
      if ($("#wholesale_market_checkbox_inventory_setting").is(":checked")) {
        console.log("hello");
		$(".forminp-radio").show();
		$('label[for="wholesale_market_prices_show_user"]').show();
      } else {
		$(".forminp-radio").hide();
		$('label[for="wholesale_market_prices_show_user"]').hide();
      }
    });
  });
})(jQuery);
