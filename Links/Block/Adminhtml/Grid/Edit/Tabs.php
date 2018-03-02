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
    protected function _prepareLayout()
    {
        $this->addTab(
            'edit_tab_main',
            [
                'label' => __('Main'),
                'content' => $this->getLayout()->createBlock(
                    \Web4pro\Links\Block\Adminhtml\Grid\Edit\Tab\Main::class
                )->toHtml()//,
                //'active' => true
            ]
        );
        $this->addTab(
            'edit_tab_conditions',
            [
                'label' => __('Conditions'),
                'content' => $this->getLayout()->createBlock(
                    \Web4pro\Links\Block\Adminhtml\Grid\Edit\Tab\Conditions::class
                )->toHtml()//,
                //'active' => true
            ]
        );
        return parent::_prepareLayout();
        
    }

}