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
 *  @package Magecom_Donation
 *  @copyright Copyright (c) 2019 Magecom, Inc. (http://www.magecom.net)
 *  @license  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Magecom\Checkout\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class Rates
 * @package Magecom\Checkout\Block\Adminhtml\Form\Field
 */
class Rates extends AbstractFieldArray
{
    /**
     * Prepare to render.
     *
     * @throws \Exception
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'rate_price',
            [
                'label' => __('Rate'),
                'class' => 'required-entry validate-number',
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Rate');
    }
}
