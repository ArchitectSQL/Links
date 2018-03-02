<?php

namespace Custom\CmsMenu\Block\Adminhtml\Menu\Edit\Tab;

use Magento\Backend\Block\Widget\Grid\Column;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended implements
    \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $pageCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        array $data = []
    ) {
        $this->pageCollectionFactory = $pageCollectionFactory;
        parent::__construct($context,$backendHelper, $data);
    }

    protected $hiddenParameters = [
        'template'
    ];

    public function getTabLabel()
    {
        return __('Grid');
    }

    public function getTabTitle()
    {
        return __('Grid');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareCollection()
    {
        $collection = $this->pageCollectionFactory->create();
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'checker',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'values' => $this->getCollection(),
                'align' => 'center',
                'sortable' => true,
                'index' => 'page_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'page_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'page_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'name'=>'page_id'
            ]
        );

        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'name'=>'title'
            ]
        );

        $this->addColumn(
            'identifier',
            [
                'header' => __('Identifier'),
                'index' => 'identifier',
                'class' => 'xxx',
                'name'=>'identifier'
            ]
        );

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'name'=>'is_active',
                'type' => 'options',
                'options' => ['1' => __('Enabled'), '0' => __('Disabled')]
            ]
        );

        return parent::_prepareColumns();
    }
}