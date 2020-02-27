/**
 * This script is a Pop-up content on site
 */
define(
    [
        'jquery',
        'Magento_Ui/js/modal/modal',
    ],
    function ($, Component) {
        'use strict';
        // Get data from phtml file
        var mageJsComponent = function (data) {
            var getData = JSON.stringify(data);
            var jsongetData = JSON.parse(getData);
            var height_value = jsongetData["height"];
            var width_value = jsongetData["width"];
            var options = {
                type: 'popup',
                responsive: true,
               innerScroll: false,
                responsiveClass: 'promo'
            };
             $(document).ready(function () {
                 //set height and width of popup model
                if (width_value >= 500) {
                    $("#popup").css("width", width_value);
                } else if (width_value == "auto") {
                        $("#popup").css("width", "auto");
                } else {
                        $("#popup").css("width", "500px");
                }
                if (height_value >= 300) {
                        $("#popup").css("height", height_value);
                } else if (height_value == "auto") {
                        $("#popup").css("height", "auto");
                } else {
                        $("#popup").css("height", "300px");
                }
                //show popup here
                var mdl = jQuery('#popup').modal(options);
                jQuery('#popup').modal('openModal');
                // close modal if clicked outside.
                $("body").click(function(e){
                      $( ".action-close" ).trigger( "click" );
                });
            });
        };
        return mageJsComponent;
    });
