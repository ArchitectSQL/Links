<?php
/**
 * WEB4PRO - Creating profitable online stores
 *
 * @author    vyurchenko@corp.web4pro.com.ua
 * @category  WEB4PRO
 * @package   Web4pro_Stockstatus
 * @copyright Copyright (c) 2017 WEB4PRO (http://www.web4pro.net)
 * @license   http://www.web4pro.net/license.txt
 */

namespace Web4pro\Stockstatus\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Add column to the 'eav_attribute_option' table
         */
        $installer->getConnection()
             ->addColumn(
                 $installer->getTable('eav_attribute_option'),
                 'image',
                 [
                     'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                     'nullable' => true,
                     'comment' => 'image'
                 ]);

         $installer->endSetup();

    }
}
