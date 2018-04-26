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
namespace Web4pro\Stockstatus\Helper;

use \Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package Web4pro\Stockstatus\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    protected $_stockStateInterface;

    /**
     * @var \Magento\Catalog\Model\ProductFactory
     */
    protected $_productLoader;

    /**
     * @var bool
     */
    protected $_typeProduct = false;

    /**
     * stock status from atribute
     */
    protected $_customStockStatus;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * @var \Magento\Framework\App\ObjectManager
     */
    protected $_objectManager;

    /**
     * Data constructor.
     * @param Context $context
     * @param \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface
     * @param \Magento\Catalog\Model\ProductFactory $_productLoader
     * @param \Magento\Framework\App\ResourceConnection $_resourceConnection
     */
    public function __construct(
        Context $context,
        \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface,
        \Magento\Catalog\Model\ProductFactory $_productLoader,
        \Magento\Framework\App\ResourceConnection $_resourceConnection
    )
    {
        $this->_stockStateInterface = $stockStateInterface;
        $this->_productLoader = $_productLoader;
        $this->_resourceConnection = $_resourceConnection;
        $this->getObjectManager();
        parent::__construct($context);
    }

    /**
     * return image
     * @param $product
     * @return $this|bool
     */
    public function getImageAttributeOption($product)
    {
        if(!$this->isShowStockImage())
        {
            return false;
        }

        $stockStatusAttribute = $product->getResource()->getAttribute('custom_stockstatus');
        $textAttribute = $product->getAttributeText('custom_stockstatus');
        $optionId = $stockStatusAttribute->getSource()->getOptionId($textAttribute);

        $url = $this->getImageUrl((int)$optionId);

        if(!count($url) || !count($url[0]) || $url[0]['image'] == '0'){
            return '';
        }else{
            return '<img class="image-stockstatus" src="' . array_shift($url[0]) . '"/>';
        }
    }

    /**
     * return image URL by option Id
     * @param $optionId
     * @return array
     */
    protected function getImageUrl($optionId)
    {
        $connection = $this->_resourceConnection->getConnection();
        $tableName  = $this->_resourceConnection->getTableName('eav_attribute_option');

        $sql = 'SELECT `image` FROM ' . $tableName . ' WHERE option_id=' . '\'' . $optionId . '\'';

        return $connection->fetchAll($sql);
    }

    /**
     * @param $product
     * @return string
     */
    public function getNewStockStatusOptions($product)
    {
        return $this->getCustomStockStatus($product);
    }
    /**
     * return stockstatus
     * @param $product
     * @return string
     */
    public function getNewStockStatus($product)
    {
        $defaultStockStatus = $this->getDefaultStockStatus($product);
        $this->_customStockStatus = $this->getCustomStockStatus($product);
        $qty = $this->getSimpleQty($product);

        switch(true)
        {
            case ($this->isShowStockLevel() && $qty && in_array($product->getTypeID(), $this->getProductTypesForCount())):
                $levelStockStatus = (int)$qty . __(' in stock');
                return $this->getStringHtml($product, $levelStockStatus);

            case ($this->isDefaultStockStatusHidden($product) && $this->_customStockStatus):
                return $this->getStringHtml($product);

            case (!$this->isDefaultStockStatusHidden($product) && !strlen($this->_customStockStatus)):
                return $this->getStringHtml($product, $defaultStockStatus);

            default :
                return $this->getStringHtml($product, $defaultStockStatus);
        }
    }

    /**
     * @param $product
     */
    public function isConfigurableProduct($product)
    {
        if($product->getTypeId() != 'configurable') return;
        $data = array();
        $data['optionsProduct'][0] = $this->getNewStockStatus($product);
        $productTypeInstance = $this->_objectManager->get('Magento\ConfigurableProduct\Model\Product\Type\Configurable');
        $productAttributeOptions = $productTypeInstance->getConfigurableAttributesAsArray($product);

        foreach ($productAttributeOptions as $id => $productAttributeOption) {
            $data['attributes'][] = $productAttributeOption['attribute_code'];
            $options[]  = $productAttributeOption['attribute_code'];
        }

        $_children = $product->getTypeInstance()->getUsedProductIds($product);
        foreach ($_children as $id)
        {
            $productChildren = $this->createObjectManager('Magento\Catalog\Model\Product')->load($id);
            $json = $this->createObjectManager('\Magento\Framework\Json\EncoderInterface');
            $getStockStatus = $this->getNewStockStatus($productChildren);
            foreach ($options as $attributeId => $option) {
                $optionsProduct[$attributeId] = $productChildren->getData($option);
            }

            $data['optionsProduct'][] = [
                              'options' => $optionsProduct,
                          'stockstatus' => $getStockStatus,
            ];
        }

        return $json->encode($data);
    }


    /**
     * return stockstatus for cart
     * @param $product
     * @return string
     */
    public function getStockStatusForProduct($product, $_typeProduct = false)
    {
        if($_typeProduct == 'cart'){
            $this->_typeProduct = true;
        }else{
            $this->_typeProduct = $_typeProduct;
        }
        $_product = $this->_productLoader->create()->load($product->getId());
        return $this->getNewStockStatus($_product);
    }

    /**
     * retrun Html string stockstatus
     *
     * @param $product
     * @param $stockStatus
     * @return string
     */
    public function getStringHtml($product, $stockStatus = '')
    {
        if($product->isAvailable() && $product->isSaleable() && $product->getQuantityAndStockStatus('is_in_stock')){
            $stockStatus .= ' ' . $this->_customStockStatus;
            $_image = $this->getImageAttributeOption($product);
            $class = 'stock available';
            $title = 'Availability';
        }else{
            $_image = '';
            $class = 'stock unavailable';
            $title = 'Unavailability';
        }

        if($this->isShowStockImage() && $this->isShowStockImageOnly()){
            if($_image){
                $stockStatus = '';
            }
        }

        if(!$this->checkNumberProductsForCustomStatus($product)){
            return '<div class="' . $class . '" title="' .  __($title) .'">
                        <span>' . $this->getDefaultStockStatus($product) . '</span>
                </div>';
        }

        return '<div class="' . $class . '" title="' .  __($title) .'">
                             ' . $_image . '
                        <span>' . $stockStatus . '</span>
                </div>';

    }

    /**
     * return default stockstatus
     * @param $product
     * @return \Magento\Framework\Phrase|string
     */
    public function getDefaultStockStatus($product)
    {
        switch (true)
        {
            case($product->isAvailable() && $product->isSaleable() && $product->getQuantityAndStockStatus('is_in_stock')):
                if($this->isStockStatusForAllProducts() && $this->isStockStatusForAllProductsText()) {
                    return __($this->isStockStatusForAllProductsText());
                }else{
                    return __('In stock');
                }

            case($this->_typeProduct):
                return '';

            case($this->isCustomStockStatusOnOutOfStock() && $this->isCustomStockStatusOnOutOfStockText()):
                return __($this->isCustomStockStatusOnOutOfStockText());

            default:
                return __('Out of stock');
        }
    }

    /**
     * return custom stockstatus(attribute)
     *
     * @param $product
     * @return string
     */
    public function getCustomStockStatus($product)
    {
        $customStockStatus = '';
        if ($product->isAvailable() && $this->checkNumberProductsForCustomStatus($product) && $product->getQuantityAndStockStatus('is_in_stock'))
        {
            $customStockStatus = $product->getAttributeText('custom_stockstatus');

            if ($customStockStatus === false)
            {
                $customStockStatus = 'In Stock';
            }
        }
        if ($product->getQuantityAndStockStatus('is_in_stock') === false)
        {
            $customStockStatus ='Out of stock';
        }
        return $customStockStatus;
    }

    /**
     * @param $product
     * @return bool
     */
    public function checkNumberProductsForCustomStatus($product)
    {

        if(!in_array($product->getTypeID(), $this->getProductTypesForCount()))
        {
            return true;
        }
        $count = $product->getData('count_products');

        $stockItem = $this->createObjectManager('Magento\CatalogInventory\Model\Stock\StockItemRepository');

        $strockQty = $stockItem->get($product->getId())->getQty();
        return $count <= $strockQty;
    }

    /**
     * @return type product
     */
    public function getProductTypesForCount()
    {
        return array(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
    }

    /**
     * @param $product
     * @return mixed
     */
    public function isDefaultStockStatusHidden($product)
    {
        return $product->getData('hide_default_stockstatus');
    }

    /**
     * @param $product
     * @return float
     */
    public function getSimpleQty($product)
    {
        return $this->_stockStateInterface->getStockQty($product->getId(), $product->getStore()->getWebsiteId());
    }

    /**
     * @return mixed
     */
    public function isCustomStockStatusOnProductListPage()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/display_at_category', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isCustomStockStatusOnProductViewPage()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/display_at_product_page', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isCustomStockStatusInShoppingCart()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/display_in_cart', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isCustomStockStatusOnOutOfStockText()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/outofstocktext', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isCustomStockStatusOnOutOfStock()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/outofstock', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isShowStockLevel()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/showstocklevel', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isShowStockImage()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/showimage', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isStockStatusForAllProductsText()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/stockstatustext', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isStockStatusForAllProducts()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/stockstatus', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function isShowStockImageOnly()
    {
        return $this->scopeConfig->getValue('web4pro_stockstatus/general/showimageonly', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * return \Magento\Framework\App\ObjectManager
     */
    public function getObjectManager()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * @param $object
     * @return mixed
     */
    public function createObjectManager($object)
    {
        return $this->_objectManager->create($object);
    }

}