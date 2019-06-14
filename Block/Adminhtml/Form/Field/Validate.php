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
 * @category Magecom
 * @package Magecom_Donation
 * @copyright Copyright (c) 2019 Magecom, Inc. (http://www.magecom.net)
 * @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magecom\Checkout\Block\Adminhtml\Form\Field;

use Magento\Config\Model\Config\Backend\Serialized;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Serialize\Serializer\Json;

/**
 * Class Validate
 * @package Magecom\Checkout\Block\Adminhtml\Form\Field
 */
class Validate extends Serialized
{
    /**
     * @var Json
     */
    private $serializer;

    /**
     * Validate constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     * @param Json|null $serializer
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null

    ) {
        $this->serializer = $serializer ?: ObjectManager::getInstance()->get(Json::class);
        parent::__construct(
            $context,
            $registry,
            $config,
            $cacheTypeList,
            $resource,
            $resourceCollection,
            $data,
            $serializer
        );
    }

    /**
     * @return Serialized|void
     */
    public function beforeSave()
    {
        if (!empty($this->getValue()) && is_array($this->getValue())) {
            $values[] = $this->getValue(); // check!!!
            $this->convertToFloat($values);
            if (array_key_exists('__empty', $values)) {
                unset($values['__empty']);
            }
            $ser = $this->serializer->serialize($values);
            $this->setValue($ser);
        }
    }

    /**
     * @param array $values
     */
    private function convertToFloat(array &$values)
    {
        foreach ($values as $key => $value) {
            if (is_array($value) && array_key_exists('rate_price', $value)) {
                $ratePrice = preg_replace('/\s+/', '', $value['rate_price']);
                $values[$key]['rate_price'] = (float)$ratePrice;
            }
        }
    }
}
