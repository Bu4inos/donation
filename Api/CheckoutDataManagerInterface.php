<?php

/**
 *  Magecom
 *
 *  NOTICE OF LICENSE
 *
 *  This source file is subject to the Open Software License (OSL 3.0)
 *  that is bundled with this package in the file LICENSE.txt.
 *  It is also available through the world-wide-web at this URL:
 *  http://opensource.org/licenses/osl-3.0.php
 *  If you did not receive a copy of the license and are unable to
 *  obtain it through the world-wide-web, please send an email
 *  to info@magecom.net so we can send you a copy immediately.
 *
 *  @category Magecom
 *  @package Magecom_Checkout
 *  @copyright Copyright (c) 2019 Magecom, Inc. (http://www.magecom.net)
 *  @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magecom\Checkout\Api;

/**
 * Interface SaveDonationInformationInterface
 *
 * @category Magecom
 * @package Magecom_Donation
 * @author Magecom
 */
interface CheckoutDataManagerInterface
{

    /**
     * Set donation to quote.
     *
     * @param string $donationCost
     * @param string $cartId
     *
     * @return mixed
     */
    public function setDonation($donationCost, $cartId);

    /**
     * Remove donation from quote.
     *
     * @param string $cartId
     *
     * @return mixed
     */
    public function removeDonation($cartId);

}
