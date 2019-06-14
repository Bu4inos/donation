<?php

/**
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

namespace Magecom\Checkout\Model\Quote\Address\Total;

use Magento\Quote\Model\Quote;
use Magento\Quote\Api\Data\ShippingAssignmentInterface;
use Magento\Quote\Model\Quote\Address\Total;
use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

/**
 * Class Donation
 * @package Magecom\Checkout\Model\Quote\Address\Total
 */
class Donation extends AbstractTotal
{
    /**
     * Collect grand total address amount
     *
     * @param Quote $quote
     * @param ShippingAssignmentInterface $shippingAssignment
     * @param Total $total
     * @return $this|AbstractTotal
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter.Found
     */
    public function collect(
        Quote $quote,
        ShippingAssignmentInterface $shippingAssignment,
        Total $total
    ) {
        if ($donation = $quote->getDonation()) {
            $total->addTotalAmount('donation', $donation);
            $total->addBaseTotalAmount('donation', $donation);
        }

        return $this;
    }

    /**
     * Add grand total information to address
     *
     * @param Quote $quote
     * @param Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    /**phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found*/
    public function fetch(Quote $quote, Total $total)
    {
        return [
            'code' => $this->getCode(),
            'title' => __('Donation'),
            'value' => $quote->getDonation(),
        ];
    }
    /**phpcs:enable*/
}
