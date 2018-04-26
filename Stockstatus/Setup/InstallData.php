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

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {

        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
          /**
         * @var
         * EavSetup
         * $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);


        /**
         *
         * Add attributes to the eav/attribute
         */
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'custom_stockstatus', [
            'type'                       => 'int',
            'backend'                    => '',
            'frontend'                   => '',
            'label'                      => 'Custom Stock Status Message',
            'input'                      => 'select',
            'class'                      => '',
            'global'                     => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible'                    => true,
            'required'                   => false,
            'user_defined'               => true,
            'default'                    => '',
            'searchable'                 => false,
            'filterable'                 => false,
            'comparable'                 => false,
            'visible_on_front'           => false,
            'used_in_product_listing'    => true,
            'visible_in_advanced_search' => false,
            'is_html_allowed_on_front'   => false,
            'note'                       => "Add messages by going to CATALOG->ATTRIBUTES->MANAGE ATTRIBUTES and clicking on the 'custom_stockstatus' attribute."
        ]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'hide_default_stockstatus', [
            'type'                      => 'int',
            'backend'                   => '',
            'frontend'                  => '',
            'label'                     => 'Hide Default Stock Status',
            'input'                     => 'select',
            'source'                    => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'global'                    => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible'                   => true,
            'required'                  => false,
            'user_defined'              => true,
            'default'                   => '',
            'searchable'                => false,
            'filterable'                => false,
            'comparable'                => false,
            'visible_on_front'          => false,
            'unique'                    => false,
            'is_configurable'           => false,
            'used_in_product_listing'   => true,
            'note'                      => 'Hide default stock status if custom status exists'
        ]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'count_products', [
            'type'                      => 'int',
            'backend'                   => '',
            'frontend'                  => '',
            'default'                   => '',
            'label'                     => 'Number of products',
            'input'                     => 'text',
            'global'                    => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_GLOBAL,
            'visible'                   => true,
            'required'                  => false,
            'user_defined'              => true,
            'searchable'                => false,
            'class'                     => 'validate-zero-or-greater',
            'filterable'                => false,
            'comparable'                => false,
            'visible_on_front'          => false,
            'unique'                    => false,
            'is_html_allowed_on_front' 	=> false,
            'used_in_product_listing'   => true,
            'note'                      => 'Minimum number of products in the stock for custom status appearance'
        ]);

        $eavSetup->updateAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'count_products',
            'apply_to',
            \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE
        );

        $entityTypeId = $eavSetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetIds = $eavSetup->getAllAttributeSetIds($entityTypeId);

        foreach ($attributeSetIds as $attributeSetId){

        $groups = [
            'custom-stock-status' => ['name' => 'Custom Stock Status', 'sort' => 40, 'id' => null]
        ];

        foreach ($groups as $k => $groupProp) {
            $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $groupProp['name'], $groupProp['sort']);
            $groups[$k]['id'] = $eavSetup->getAttributeGroupId($entityTypeId, $attributeSetId, $groupProp['name']);
        }

        // update attributes group and sort
        $attributes = [
            'custom_stockstatus'       => ['group' => 'custom-stock-status', 'sort' => 10],

            'hide_default_stockstatus' => ['group' => 'custom-stock-status', 'sort' => 30],

            'count_products'           => ['group' => 'custom-stock-status', 'sort' => 50],
             ];

        foreach ($attributes as $attributeCode => $attributeProp) {
            $eavSetup->addAttributeToGroup(
                $entityTypeId,
                $attributeSetId,
                $groups[$attributeProp['group']]['id'],
                $attributeCode,
                $attributeProp['sort']
            );
        }

        $stockstatusTabName = 'Custom Stock Status';
        //Add new tab
        $eavSetup->addAttributeGroup($entityTypeId, $attributeSetId, $stockstatusTabName, 40);
        $eavSetup->updateAttributeGroup(
            $entityTypeId,
            $attributeSetId,
            'Custom Stock Status',
            'attribute_group_code',
            'custom-stock-status'
        );
        $eavSetup->updateAttributeGroup(
            $entityTypeId,
            $attributeSetId,
            'Custom Stock Status',
            'tab_group_code',
            'advanced'
        );

       }
        $setup->endSetup();

    }
}
