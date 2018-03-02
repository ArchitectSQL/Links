<?php
/**
 * Links Schema Setup.
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2016 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Web4pro\Links\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('web4pro_links')
        )->addColumn(
            'entity_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true, ],
            'Links Record Id'
        )->addColumn(
            'titlelink',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Title'
        )->addColumn(
            'path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '255',
            ['nullable' => false],
            'Path'
        )->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [],
            'Sort Order'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            [],
            'Active Status'
        )->setComment(
            'Row Data Table'
        );
        $installer->getConnection()->createTable($table);


            $table = $installer->getConnection()->newTable(
                $installer->getTable('links_cms_pages')
            )->addColumn('id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                ],
                'id'
            )->addColumn(
                'link_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['nullable' => false],
                'link_id'
            )->addColumn(
                'page_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false],
                'page_id'
            )->addForeignKey(
                $installer->getFkName('links_cms_pages','link_id','web4pro_links','entity_id'),
                'link_id',
                $installer->getTable('web4pro_links'),
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('links_cms_pages','page_id','cms_page','page_id'),
                'page_id',
                $installer->getTable('cms_page'),
                'page_id',
                \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
            )->setComment('Links Pages');
            $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}
