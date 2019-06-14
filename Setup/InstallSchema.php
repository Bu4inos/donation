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

namespace Magecom\Checkout\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Magecom\Checkout\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Add new column to sales_order, quote and sales_invoice tables.
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        /**
         * Update table 'sales_order'
         */
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order'),
            'donation',
            [
                'type' => Table::TYPE_DECIMAL,
                'length' => '12,4',
                'nullable' => true,
                'comment' => 'Donation'
            ]
        );

        /**
         * Update table 'sales_invoice'
         */
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_invoice'),
            'donation',
            [
                'type' => Table::TYPE_DECIMAL,
                'length' => '12,4',
                'nullable' => true,
                'comment' => 'Donation'
            ]
        );

        /**
         * Update table 'quote'
         */
        $setup->getConnection()->addColumn(
            $setup->getTable('quote'),
            'donation',
            [
                'type' => Table::TYPE_DECIMAL,
                'length' => '12,4',
                'nullable' => true,
                'comment' => 'Donation'
            ]
        );

        $installer->endSetup();
    }
}
