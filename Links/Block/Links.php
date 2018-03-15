<?php

namespace Web4pro\Links\Block;

class Links extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Web4pro\Links\Model\GridFactory
     */
    protected $gridFactory;
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;
    /**
     * @var \Web4pro\Links\Model\LinksPagesFactory
     */
    protected $linksPages;
    /**
     * @var \Magento\Cms\Model\Page
     */
    protected $page;
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    public $getRequest;
    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $resource;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Web4pro\Links\Model\GridFactory $gridFactory,
        \Web4pro\Links\Model\LinksPagesFactory $linksPages,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Model\Page $page,
        \Magento\Framework\App\ResourceConnection $Resource
    ) {
        parent::__construct($context);
        $this->resource = $Resource;
        $this->gridFactory = $gridFactory;
        $this->pageFactory = $pageFactory;
        $this->linksPages = $linksPages;
        $this->page = $page;
        $this->getRequest = $context->getRequest();
    }

    /**
     * @return int|void
     */
    public function pageId()
    {
        if ($this->page->getId()) {
            $pageId = $this->page->getId();
            return $pageId;
        }
    }

    /**
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function outputLinks()
    {
        $pageId = $this->pageId();
        $collection = $this->gridFactory->create()->getCollection();
        $secondTableName = $this->resource->getTableName('links_cms_pages');
        /**  */
        $collection->addFieldToSelect(['path','titlelink','status'])
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('second.page_id', $pageId)
            ->setOrder('sort_order','ASC')
            ->getSelect()->joinLeft(array('second' => $secondTableName),
            'main_table.entity_id = second.link_id');
        
        return $collection;

    }
}