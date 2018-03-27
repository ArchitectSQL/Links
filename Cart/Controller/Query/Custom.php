<?php
namespace Web4pro\Cart\Controller\Query;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
class Custom extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;

    public function __construct(
        Context  $context,
        ResultFactory $resultJsonFactory

    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

        
 
    public function execute()
    {

        var_dump($this->getRequest()->getPost());exit();
        $resultJson = $this->resultJsonFactory->create(ResultFactory::TYPE_JSON);
        return $resultJson->setData(['success' => 'test']);
        
    }
}