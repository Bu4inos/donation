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

namespace Magecom\Checkout\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\ObjectManager;

/**
 * Class CheckoutConfigProvider
 * @package Magecom\Checkout\Model
 */
class CheckoutConfigProvider implements ConfigProviderInterface
{
    /**
     * Path to config enable checkout module.
     */
    const PATH_ENABLED_CHECKOUT = 'magecom_checkout_fields/general/enable_magecom_checkout';

    /**
     * Path to config short text for checkout module.
     */
    const PATH_SHORT_DESCRIPTION_CHECKOUT = 'magecom_checkout_fields/general/magecom_short_text_checkout';

    /**
     * Path to config rates for checkout module.
     */
    const PATH_RATES_CHECKOUT = 'magecom_checkout_fields/general/magecom_rates_checkout';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * CheckoutConfigProvider constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param Json|null $serializer
     * phpcs:disable MEQP2.Classes.ConstructorOperations.CustomOperationsFound
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        Json $serializer = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
    }
    /**phpcs:disable*/

    /**
     * Get values for checkout module.
     *
     * @return array
     */
    public function getConfig()
    {
        $donationConfig['checkoutDonation'] = [
            'donationEnable' => $this->getModuleEnable(),
            'donationShortDescription' => $this->getTitle(),
            'donationRates' => $this->getRates(),
        ];
        return $donationConfig;
    }

    /**
     * Get enable value for checkout module.
     *
     * @return boolean
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getModuleEnable()
    {
        $result = boolval($this->scopeConfig->getValue(
            self::PATH_ENABLED_CHECKOUT,
            ScopeInterface::SCOPE_STORE
        ));
        return $result;
    }

    /**
     * Get checkout short description.
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->scopeConfig->getValue(
            self::PATH_SHORT_DESCRIPTION_CHECKOUT,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get checkout rates.
     *
     * @return mixed
     */
    public function getRates()
    {
        $stringRates = $this->scopeConfig->getValue(
            self::PATH_RATES_CHECKOUT,
            ScopeInterface::SCOPE_STORE
        );
        $values = $this->serializer->unserialize($stringRates);
        foreach ($values as $value) {
            if (is_array($value) && array_key_exists('rate_price', $value)) {
                $rates[] = $value['rate_price'];
            }
        }
        return $rates;
    }
}
