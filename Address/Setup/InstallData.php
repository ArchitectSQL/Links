<?php
namespace Web4pro\Address\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\Customer;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig       = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute('customer_address','type',
            [
                'type'         => 'int',
                'label'        => 'Custom Web4pro',
                'input'        => 'select',
                'source' => 'Web4pro\Address\Model\Customer\Attribute\Source\AddressField',
                'required'     => false,
                'visible'      => true,
                'user_defined' => true,
                'sort_order' => 999,
                'position' => 999,
                'system' => 0,
            ]
        );
        $sampleAttribute = $this->eavConfig->getAttribute('customer_address','type');

        // more used_in_forms ['adminhtml_checkout','adminhtml_customer','adminhtml_customer_address','customer_account_edit','customer_address_edit','customer_register_address']
        $sampleAttribute->setData(
            'used_in_forms',
            ['adminhtml_checkout','checkout_register','adminhtml_customer','adminhtml_customer_address','customer_register_address','customer_address_edit']


        );
        $sampleAttribute->save();
    }
}
