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
namespace Web4pro\Stockstatus\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class RemoveBlockInCatalogView
 * @package Web4pro\Stockstatus\Observer
 */
class RemoveBlockInView implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * RemoveBlockInView constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * remove block for product view if enable configure
     * @param Observer $observer
     * @return bool
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Framework\View\Layout $layout */
        $layout = $observer->getLayout();

        $actionName = $observer->getEvent()->getFullActionName();

        if($actionName !== 'catalog_product_view') return false;

        $typeProduct = $this->getTypeProduct($observer);
        $blockName   = $this->getNameBlock($typeProduct);
        $block       = $layout->getBlock($blockName);

        if ($block) {

            $remove = $this->_scopeConfig->getValue(
                'web4pro_stockstatus/general/display_at_product_page',
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );

            if ($remove) {
                $layout->unsetElement('product.info.type');
            }
        }
    }

    /**
     * return name block for type product to get the block
     * @param bool $type
     * @return bool|string
     */
    protected function getNameBlock($type = false)
    {
        switch ($type)
        {
            case('simple'):
                return 'product.info.simple';

            case('grouped'):
                return 'product.info.grouped';

            case('configurable'):
                return 'product.info.configurable';

            case('bundle'):
                return 'product.info.bundle';

            case('virtual'):
                return 'product.info.virtual';

            case('downloadable'):
                return 'product.info.downloadable';

            default:
                return false;
        }
    }

    /**
     * return type product for product view using handle
     * @param $observer
     * @return string
     */
    protected function getTypeProduct($observer)
    {
        $handles = $observer->getEvent()->getLayout()->getUpdate()->getHandles();
        foreach ($handles as $handle) {
            switch ($handle)
            {
                case('catalog_product_view_type_simple'):
                    return 'simple';

                case('catalog_product_view_type_grouped'):
                    return 'grouped';

                case('catalog_product_view_type_configurable'):
                    return 'configurable';

                case('catalog_product_view_type_bundle'):
                    return 'bundle';

                case('catalog_product_view_type_virtual'):
                    return 'virtual';

                case('catalog_product_view_type_downloadable');
                    return 'downloadable';
            }
        }
    }

}