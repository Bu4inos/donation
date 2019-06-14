
/*
 * Magecom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@magecom.net so we can send you a copy immediately.
 *
 * @category Magecom
 * @package Magecom_Checkout
 * @copyright Copyright (c) 2019 Magecom, Inc. (http://www.magecom.net)
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define(
    [
        'ko',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'Magento_Catalog/js/price-utils'

    ],
    function (ko, Component, quote, totals, priceUtils) {
        "use strict";
        var checkoutConfig = window.checkoutConfig,
            donationConfig = checkoutConfig ? checkoutConfig.checkoutDonation : {};


        return Component.extend({
            defaults: {
                template: 'Magecom_Checkout/amount'
            },

            isEnabled: donationConfig.donationEnable,

            getValue: function () {
                var price = totals.getSegment('donation').value;
                return priceUtils.formatPrice(price, quote.getPriceFormat());
            }

        });
    }
);
