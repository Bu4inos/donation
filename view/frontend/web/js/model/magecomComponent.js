
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
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/url-builder',
        'mage/storage',
        'Magento_Checkout/js/action/get-totals',
        'Magento_Checkout/js/model/totals',

    ],
    function ($, ko, Component, quote, urlBuilder, storage, getTotals, totals) {
        "use strict";
        var checkoutConfig = window.checkoutConfig,
            donationConfig = checkoutConfig ? checkoutConfig.checkoutDonation : {};

        return Component.extend({
            defaults: {
                template: 'Magecom_Checkout/magecomComponent'
            },

            initObservable: function () {
                this._super()
                    .observe({
                        isDonate: false,
                    });
                return this;
            },

            getDonationOption: donationConfig.donationRates,

            isEnabled: donationConfig.donationEnable,

            getShortDescription: donationConfig.donationShortDescription,

            checkIsDonate: function () {
                if (!this.isDonate()) {
                    let donation = 0;
                    let quoteId = quote.getQuoteId();
                    this.setDonation(donation, quoteId);
                }
            },

            changeDonationAmount: function (element, event) {
                let quoteId = quote.getQuoteId();
                if ($(event.target).length && quoteId) {
                    let donation = $(event.target).prop('selected', true).val();
                    this.setDonation(donation, quoteId);
                }
            },

            setDonation: function (donation, quoteId) {
                let deferred = $.Deferred();
                let serviceUrl = urlBuilder.createUrl('/set-donation/:donationCost/:cartId', {
                    donationCost: donation,
                    cartId: quoteId
                });
                return storage.put(serviceUrl, false).done(
                    function (response) {
                        if (response) {
                            totals.isLoading(true);
                            getTotals(deferred);
                            $.when(deferred).done(function () {
                                totals.isLoading(false);
                            });
                        }
                    }
                ).fail(
                    function (response) {
                    }
                );
            }
        });
    }
);
