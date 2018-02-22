<?php
/**
 * Links Record Index Controller.
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2017 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Web4pro\Links\Controller\Adminhtml\Grid;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Mapped eBay Order List page.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Web4pro_Links::grid_list');
        $resultPage->getConfig()->getTitle()->prepend(__('Links List'));
        return $resultPage;
    }

    /**
     * Check Order Import Permission.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Web4pro_Links::grid_list');
    }
}
