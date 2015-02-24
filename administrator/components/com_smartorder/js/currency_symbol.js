/**
 * @package    SmartOrder for Joomla 3.x
 * @author     Organik Online Media Ltd.
 * @copyright  Copyright (C) 2013- Organik Online Media Ltd. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @see        LICENSE.txt
 */

(function($) {

    $(function() {
        $('#currency_code').change(function() {
            $.get('components/com_smartorder/currency_symbol.php', { code: $('#currency_code').val() }, function(result) {
                $('#currency_symbol').val(result);
            });
        });
    });

})(jQuery);