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

use Magento\Framework\Event\ObserverInterface;

/**
 * Class CatalogCheckIsUsingStaticUrlsAllowedObserver
 * @package Web4pro\Stockstatus\Observer
 */
class CatalogCheckIsUsingStaticUrlsAllowedObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * CatalogCheckIsUsingStaticUrlsAllowedObserver constructor.
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->_request = $request;
    }

    /**
     * static urls allowed for product attribute image 'custom_stockstatus' wisywig => save image
     * @param \Magento\Framework\Event\Observer $observer
     * @return bool
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!$this->_request->getParam('static_urls_allowed')) return false;

        $checkResult = $observer->getEvent()->getResult();
        $checkResult->isAllowed = true;
    }
}