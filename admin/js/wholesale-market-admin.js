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
    //Hide or Show After checking checkbox of inventory setting
    $("#wholesale_market_checkbox_inventory_setting").click(function () {
      if ($("#wholesale_market_checkbox_inventory_setting").is(":checked")) {
        $(".forminp-radio").show();
        $('label[for="wholesale_market_prices_show_user"]').show();
        let valueofradio = $(
          'input[name="wholesale_market_prices_show_user"]'
        ).val();
        if (valueofradio == "set_common_quantity") {
          $("#Wholesale_minimum_quantity_all").show();
          $('label[for="Wholesale_minimum_quantity_all"]').show();
        }
      } else {
        $(".forminp-radio").hide();
        $('label[for="wholesale_market_prices_show_user"]').hide();
        $("#Wholesale_minimum_quantity_all").hide();
        $('label[for="Wholesale_minimum_quantity_all"]').hide();
      }
    });
    // Hide or Show Wholesale price text field  When radio button will be checked on Invntory setting
    $('input[name="wholesale_market_prices_show_user"]').click(function () {
      let valueofradio = $(this).val();
      if (valueofradio == "set_common_quantity") {
        $("#Wholesale_minimum_quantity_all").show();
        $('label[for="Wholesale_minimum_quantity_all"]').show();
      } else {
        $("#Wholesale_minimum_quantity_all").hide();
        $('label[for="Wholesale_minimum_quantity_all"]').hide();
      }
    });

    $("#Wholesale_minimum_quantity_all").after(
      "<span id='massage' style='color:red'> </span>"
    );
    $("#wholesale_simple_product_min_qty").after(
      "<span id='massage_for_simple_quantity' style='color:red'> </span>"
    );
    $("#wholesale_simple_product_price").after(
      "<span id='massage_for_simple_wholesale_price' style='color:red'> </span>"
    );

    $("#Wholesale_minimum_quantity_all").focusout(function () {
      let valueForMinimumqty = $(this).val();
      if (parseInt(valueForMinimumqty) < 0) {
        var check = "negative";
      }
      if (
        valueForMinimumqty == "" ||
        valueForMinimumqty == null ||
        check == "negative"
      ) {
        $(this).val("");
        $("#massage").html("Invalid Value");
      } else {
        $("#massage").html("");
      }
    });

    $("#wholesale_simple_product_price").focusout(function () {
      let valueForWholesalePrice = $("#wholesale_simple_product_price").val();
      let valueForRegularPrice = $("#_regular_price").val();
      if (parseInt(valueForWholesalePrice) < 0) {
        var checkSimpleWholesalePrice = "negative";
      }

      if (
        valueForWholesalePrice == "" ||
        valueForWholesalePrice == null ||
        checkSimpleWholesalePrice == "negative"
      ) {
        $(this).val("");
        $("#massage_for_simple_wholesale_price").html("Invalid Value");
      } else {
        $("#massage_for_simple_wholesale_price").html("");
      }

      if (parseInt(valueForWholesalePrice) >= parseInt(valueForRegularPrice)) {
        $(this).val("");
        $("#massage_for_simple_wholesale_price").html(
          "Wholesale Price Cannot be Greater then Regular Price"
        );
      } else {
        $("#massage_for_simple_wholesale_price").html("");
      }
    });

    $("#wholesale_simple_product_min_qty").focusout(function () {
      let valueForMinimumqty = $(this).val();
      if (parseInt(valueForMinimumqty) < 0) {
        var check = "negative";
      }
      if (
        valueForMinimumqty == "" ||
        valueForMinimumqty == null ||
        check == "negative"
      ) {
        $(this).val("");
        $("#massage_for_simple_quantity").html("Invalid Value");
      } else {
        $("#massage_for_simple_quantity").html("");
      }
    });
  });
})(jQuery);
