<?php

namespace Web4pro\Links\Block;

class Links extends \Magento\Framework\View\Element\Template
{
    protected $gridFactory;

    protected $pageFactory;

    protected $linksPages;

    protected $page;
    
    public $getRequest;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Web4pro\Links\Model\GridFactory $gridFactory,
                                \Web4pro\Links\Model\LinksPagesFactory $linksPages,
                                \Magento\Cms\Model\PageFactory $pageFactory,
                                \Magento\Cms\Model\Page $page)
    {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        $this->pageFactory = $pageFactory;
        $this->linksPages = $linksPages;
        $this->page = $page;
        $this->getRequest = $context->getRequest();
    }

    public function pageId()
    {
        if ($this->page->getId()) {
            $pageId = $this->page->getId();
            return $pageId;
        }
         
    }
    
    public function manyToMany()
    {
        $collectionMany = $this->linksPages->create();

        return $collectionMany;
    }
    public function collection()
    {
        /*$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $productCollection = $objectManager->create('\Web4pro\Links\Model\GridFactory');
        $collection = $productCollection->create();*/
        $collection = $this->gridFactory->create();

        return $collection;
    }
}