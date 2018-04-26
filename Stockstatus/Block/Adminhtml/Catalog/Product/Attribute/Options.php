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
namespace Web4pro\Stockstatus\Block\Adminhtml\Catalog\Product\Attribute;

use Magento\Framework\View\Element\Template;

/**
 * Class Options
 * @package Web4pro\Stockstatus\Block\Adminhtml\Catalog\Product\Attribute
 */
class Options extends \Magento\Eav\Block\Adminhtml\Attribute\Edit\Options\Options
{
    /**
     * Options constructor.
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory
     * @param \Magento\Framework\Validator\UniversalFactory $universalFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute\Option\CollectionFactory $attrOptionCollectionFactory,
        \Magento\Framework\Validator\UniversalFactory $universalFactory,
        array $data = []
    ) {
        parent::__construct($context,$registry,$attrOptionCollectionFactory,$universalFactory);

        if ($this->getAttributeObject()->getData('attribute_code') == 'custom_stockstatus') {
            $this->setTemplate('Web4pro_Stockstatus::stockstatus/catalog/product/attribute/options.phtml');
        }

        return $this;
    }

    /**
     * @param $option
     * @param $inputType
     * @param $defaultValues
     * @return array
     */
    protected function _prepareUserDefinedAttributeOptionValues($option, $inputType, $defaultValues)
    {
        $optionId = $option->getId();

        $value['checked']    = in_array($optionId, $defaultValues) ? 'checked="checked"' : '';
        $value['intype']     = $inputType;
        $value['id']         = $optionId;
        $value['sort_order'] = $option->getSortOrder();
        
        if ($this->getAttributeObject()->getData('attribute_code') == 'custom_stockstatus') {
            $value['image'] = $option->getImage();
        }

        foreach ($this->getStores() as $store) {
            $storeId = $store->getId();
            $storeValues = $this->getStoreOptionValues($storeId);
            $value['store' . $storeId] = isset(
                $storeValues[$optionId]
            ) ? $this->escapeHtml(
                $storeValues[$optionId]
            ) : '';
        }

        return [$value];
    }
}