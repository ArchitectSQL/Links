<?php

namespace Web4pro\Links\Block\Adminhtml\Grid\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;

class Main extends Generic implements TabInterface
{

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Create Link');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Create Link');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Generic
     */
    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('row_data');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);

        if ($model->getId()) {
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        }

        $fieldset->addField(
            'titlelink',
            'text',
            ['name' => 'titlelink', 'label' => __('Title'), 'title' => __('Title'), 'required' => true]
        );
        $fieldset->addField(
            'path',
            'text',
            ['name' => 'path', 'label' => __('Path'), 'title' => __('Path'), 'required' => true]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'required' => true,
                'options' => ['1' => __('Enable'), '0' => __('Disable')]
            ]
        );

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        $fieldset->addField('sort_order', 'text', ['name' => 'sort_order', 'label' => __('Position')]);

        $form->setValues($model->getData());

        $this->setForm($form);
        return parent::_prepareForm();
    }
}