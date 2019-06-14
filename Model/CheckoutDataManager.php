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

namespace Magecom\Checkout\Model;

use Magecom\Checkout\Api\CheckoutDataManagerInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Cart\Totals;
use Magento\Quote\Model\QuoteIdMask;
use Magento\Quote\Model\QuoteIdMaskFactory;


/**
 * Class CheckoutDataManager
 * @package Magecom\Checkout\Model
 */
class CheckoutDataManager implements CheckoutDataManagerInterface
{
    /**
     * Default quote id mask default size
     */
    const QUOTE_ID_MASK_DEFAULT_SIZE = 32;

    /**
     * Reg exp for donation cost.
     */
    const REG_EXP_FOR_DONATION = '/^\d{1,12}$/';

    /**
     * @var QuoteIdMaskFactory
     */
    private $quoteIdMaskFactory;

    /**
     * Quote repository.
     *
     * @var CartRepositoryInterface
     */
    protected $quoteRepository;

    /**
     * @var Totals
     */
    protected $totals;

    /**
     * Constructs a coupon read service object.
     *
     * @param CartRepositoryInterface $quoteRepository Quote repository.
     */
    public function __construct(
        CartRepositoryInterface $quoteRepository,
        Totals $totals,
        QuoteIdMaskFactory $quoteIdMaskFactory
    ) {
        $this->quoteRepository = $quoteRepository;
        $this->quoteIdMaskFactory = $quoteIdMaskFactory;
        $this->totals = $totals;
    }

    /**
     * Set donation to quote.
     *
     * @param string $donationCost
     * @param string $cartId
     *
     * @return bool|mixed
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     * @throws ValidatorException
     */
    public function setDonation($donationCost, $cartId)
    {
        if ($this->validateQuoteMask($cartId) && $this->validateDonationCost($donationCost)) {
            /** @var $quoteIdMask QuoteIdMask */
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            if ($quoteId = $quoteIdMask->getQuoteId()) {
                /** @var  \Magento\Quote\Model\Quote $quote */
                $quote = $this->quoteRepository->getActive($quoteId);
                $donationCost = (float)$donationCost;

                if (!$quote->getItemsCount()) {
                    throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
                }

                try {
                    $quote->setDonation($donationCost);
                    $this->quoteRepository->save($quote->collectTotals());// recalculate quote totals
                } catch (\Exception $e) {
                    throw new CouldNotSaveException(__('Could not apply donation'));
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Remove donation form quote.
     *
     * @param string $cartId
     *
     * @return bool|mixed
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     * @throws ValidatorException
     */
    public function removeDonation($cartId)
    {
        if ($this->validateQuoteMask($cartId)) {
            /** @var $quoteIdMask QuoteIdMask */
            $quoteIdMask = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id');
            if ($quoteId = $quoteIdMask->getQuoteId()) {
                /** @var  \Magento\Quote\Model\Quote $quote */
                $quote = $this->quoteRepository->getActive($quoteId);

                if (!$quote->getItemsCount()) {
                    throw new NoSuchEntityException(__('Cart %1 doesn\'t contain products', $cartId));
                }

                try {
                    $quote->setDonation(null);
                    $this->quoteRepository->save($quote->collectTotals());
                } catch (\Exception $e) {
                    throw new CouldNotDeleteException(__('Could not delete donation'));
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Validate quote mask.
     *
     * @param $quoteMask
     * @return bool
     * @throws ValidatorException
     */
    private function validateQuoteMask($quoteMask)
    {
        if (isset($quoteMask) && is_string($quoteMask) && strlen($quoteMask) <= self::QUOTE_ID_MASK_DEFAULT_SIZE) {
            return true;
        }

        throw new ValidatorException(__('Not valid quote mask.'));
    }

    /**
     * Validate donation cost.
     *
     * @param $donation
     * @return bool
     * @throws ValidatorException
     */
    private function validateDonationCost($donation)
    {
        if (isset($donation) && preg_match(self::REG_EXP_FOR_DONATION, $donation)) {
            return true;
        }

        throw new ValidatorException(__('Not valid donation cost.'));
    }
}

