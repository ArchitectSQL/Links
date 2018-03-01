<?php

/**
 * Links Admin Cagegory Map Record Save Controller.
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2016 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Web4pro\Links\Controller\Adminhtml\Grid;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Web4pro\Links\Model\GridFactory
     */
    protected $gridFactory;
    
    protected $linksPages;

    protected $pageFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Web4pro\Links\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Web4pro\Links\Model\GridFactory $gridFactory,
        /*\Web4pro\Links\Model\LinksPagesFactory $linksPages,*/
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
        //$this->linksPages = $linksPages;
        $this->pageFactory = $pageFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        //var_dump($data);exit();
        if (!$data) {
            $this->_redirect('grid/grid/edit');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['entity_id'])) {
                $rowData->setEntityId($data['entity_id']);
            }
            
            $rowData->save();
            
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('grid/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Web4pro_Links::save');
    }
}
