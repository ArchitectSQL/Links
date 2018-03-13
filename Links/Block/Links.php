<?php

namespace Web4pro\Links\Block;

class Links extends \Magento\Framework\View\Element\Template
{
    protected $gridFactory;

    protected $pageFactory;

    protected $linksPages;

    protected $page;
    
    public $getRequest;

    protected $resource;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Web4pro\Links\Model\GridFactory $gridFactory,
                                \Web4pro\Links\Model\LinksPagesFactory $linksPages,
                                \Magento\Cms\Model\PageFactory $pageFactory,
                                \Magento\Cms\Model\Page $page,
                                \Magento\Framework\App\ResourceConnection $Resource)
    {
        parent::__construct($context);
        $this->resource = $Resource;
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
    
    public function modelLinksPages()
    {
        $model = $this->linksPages->create();

        return $model;
    }

    public function modelLinks()
    {
        $model = $this->gridFactory->create();

        return $model;
    }

    public function getAllPages()
    {
        $arrayPages = $this->modelLinksPages()->getCollection()->addFieldToSelect('page_id');
        $pages = array();
        foreach ($arrayPages as $page){
            array_push($pages,$page->getPageId());
        }

        return $pages;
    }

    public function outputLinks()
    {
        $pageId = $this->pageId();
        $collection = $this->gridFactory->create()->getCollection();
        $second_table_name = $this->resource->getTableName('links_cms_pages');
        $collection->addFieldToSelect(['path','titlelink','status'])
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('second.page_id', $pageId)
            ->setOrder('sort_order','ASC')
            ->getSelect()->joinLeft(array('second' => $second_table_name),
            'main_table.entity_id = second.link_id');//->where('second.page_id = '.$pageId);
        echo $collection->getSelect()->__toString();
        exit();
        return $collection;

    }
}