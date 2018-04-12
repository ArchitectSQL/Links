<?php

namespace Web4pro\EditAddress\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('web4pro_edit_quote_address')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('web4pro_edit_quote_address')
            )
                ->addColumn(
                    'address_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Address ID'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Type'
                )
                ->setComment('Quote Address Table');
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('web4pro_edit_order_address')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('web4pro_edit_order_address')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Type'
                )
                ->setComment('Order Address Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}