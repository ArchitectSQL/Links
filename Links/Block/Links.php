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
        if (!empty($pageId)) {

            $linksPages = $this->modelLinksPages()->getCollection()->addFieldToFilter('page_id',$pageId);
            // Select titlelink from web4pro_links as l inner join links_cms_pages as m on l.entity_id=m.link_id where m.page_id=1
            $idsLinkPage = array();
            foreach ($linksPages as $linkpage){
                array_push($idsLinkPage,$linkpage->getLinkId());
            }
            $links = $this->modelLinks()->getCollection()->addFieldToFilter('entity_id', array('in' => $idsLinkPage))
                ->addFieldToFilter('status',1)
                ->setOrder('sort_order','ASC');

            return $links;
        }

    }
}