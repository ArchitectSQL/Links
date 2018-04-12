<?php

namespace Web4pro\EditAddress\Setup;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use \Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use \Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;
    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;
    private $eavSetupFactory;
    private $eavConfig;

    /**
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }


    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /*if (version_compare($context->getVersion(), 'VERSION') < 0) {*/
            /** @var CustomerSetup $customerSetup */
            $customerSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            /**
             * 
             */
            $customerEntity = $customerSetup->getEntityType('customer');
            //$attributeSetId = $customerEntity->getDefaultAttributeSetId();

            /** @var $attributeSet AttributeSet */
            //$attributeSet = $this->attributeSetFactory->create();
            //$attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute('customer_address', 'type',
                [
                    'type' => 'int',
                    'label' => 'Address Type1111',
                    'input' => 'select',
                    'source' => 'Web4pro\EditAddress\Model\Address\Type',
                    'global' => true,
                    'visible' => true,
                    'required' => true,
                    'user_defined' => true,
                    'system' => 0,
                    'group' => 'General',
                    'visible_on_front' => true,
                    'sort_order' => 1000,
                    'position' => 1000,
                ]
            );

            $attribute = $this->eavConfig->getAttribute('customer_address', 'type')
                ->addData(['used_in_forms' => [
                    'adminhtml_customer_address',
                    'customer_address_edit',
                    'customer_register_address'
                ]]);
            $attribute->save();
        }
   /* }*/
}