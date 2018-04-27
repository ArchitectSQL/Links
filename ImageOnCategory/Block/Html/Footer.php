<?php

namespace Web4pro\ImageOnCategory\Block\Html;

class Footer extends \Magento\Theme\Block\Html\Footer
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */    
    protected $objectManager;

    /**
     * Footer constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Http\Context $httpContext
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = [])
    {
        $this->objectManager = $objectManager;
        $this->httpContext = $httpContext;
        $this->_registry = $registry;
        parent::__construct($context,$httpContext);

    }

    public function getMediaUrl(){

        $media_dir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $media_dir;
    }
    public function existsCategory()
    {
        $currentCategory = $this->_registry->registry('current_category');
        return $currentCategory->getThumbnail();
    }
    /**
     * @return mixed
     */
    public function getCurrentCategory()
    {
        $currentCategory = $this->_registry->registry('current_category');
        $pathImage = $this->getMediaUrl().'catalog/category/'.$currentCategory->getThumbnail();
        return $pathImage;
    }
}