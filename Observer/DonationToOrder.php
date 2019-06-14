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

namespace Magecom\Checkout\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;

/**
 * Class DonationToOrder
 *
 * @package Magecom\Checkout\Observer
 */
class DonationToOrder implements ObserverInterface
{
    /**
     * Set donation to order.
     *
     * @param Observer $observer
     * @throws CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        try {
            $quote = $observer->getEvent()->getQuote();
            $order = $observer->getEvent()->getOrder();

            if ($quote->getId() && $order->getIncrementId()) {
                if (!$order->getDonation() && $quote->getDonation()) {
                    $order->setDonation($quote->getDonation());
                }
            }
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__('Could not save donation to order'));
        }
    }
}
