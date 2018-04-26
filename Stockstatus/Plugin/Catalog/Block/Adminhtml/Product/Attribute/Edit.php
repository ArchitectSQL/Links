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
namespace Web4pro\Stockstatus\Plugin\Catalog\Block\Adminhtml\Product\Attribute;

/**
 * Class Edit
 * @package Web4pro\Stockstatus\Plugin\Catalog\Block\Adminhtml\Product\Attribute
 */
class Edit
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    public $_request;

    /**
     * @var \Magento\Eav\Model\Attribute
     */
    public $_attribute;

    /**
     * Edit constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Eav\Model\Attribute $attribute
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Eav\Model\Entity\Attribute $attribute
    )
    {
        $this->_request = $request;
        $this->_attribute = $attribute;
    }

    /**
     * @return bool
     */
    public function afterGetValidationUrl(\Magento\Catalog\Block\Adminhtml\Product\Attribute\Edit $object, $result)
    {
        $attribute = $this->_attribute->load($this->_request->getParam('attribute_id'));

        if($attribute->getAttributeCode() == 'custom_stockstatus')
        {
            return false;
        }
    }
}
