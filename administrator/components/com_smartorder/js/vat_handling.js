/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

(function($) {

    $(function() {
        var $netPrice = $('[name="price"]');
        var $vatPercent = $('[name="vat_percent"]');
        var $grossPrice = $('[name="price_gross"]');

        var netToGross = function() {
            try {
                var netPrice = parseFloat($netPrice.val());
                var vatPercent = parseFloat($vatPercent.val());
                var gross = netPrice + (netPrice * vatPercent / 100.0);
                $grossPrice.val(gross.toFixed(2));
            } catch (e) {}
        };

        var grossToNet = function() {
            try {
                var grossPrice = parseFloat($grossPrice.val());
                var vatPercent = parseFloat($vatPercent.val());
                var net = grossPrice / ((100.0 + vatPercent) / 100.0);
                $netPrice.val(net.toFixed(2));
            } catch (e) {}
        };

        $netPrice.keyup(netToGross);
        $vatPercent.keyup(netToGross);
        $grossPrice.keyup(grossToNet);
    });

})(jQuery);