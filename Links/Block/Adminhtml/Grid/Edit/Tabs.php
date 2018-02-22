<?php

namespace Web4pro\Links\Block\Adminhtml\Grid\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('grid_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Your Title'));
    }

    /**
     * Prepare Layout
     *
     * @return $this
     */
    /*protected function _prepareLayout()
    {
        $this->addTab(
            'main',
            [
                'label' => __('Products'),
                'url' => $this->getUrl('grid/*//*grid', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
        $this->addTab(
            'conditions',
            [
                'label' => __('conditions'),
                'url' => $this->getUrl('grid/*//*grid', ['_current' => true]),
                'class' => 'ajax'
            ]
        );
        return parent::_prepareLayout();
        
    }*/

}