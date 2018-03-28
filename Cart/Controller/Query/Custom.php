<?php
namespace Web4pro\Cart\Controller\Query;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
class Custom extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    protected $_quoteRepository;
    
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Checkout\Model\Cart
     */
    protected $cart;

    /**
     * @var ResultFactory
     */
    protected $resultJsonFactory;
    
    public function __construct(
        Context  $context,
        ResultFactory $resultJsonFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Cart $cart

    ) {
        $this->cart = $cart;
        $this->_checkoutSession = $checkoutSession;
        $this->_quoteRepository = $quoteRepository;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function execute()
    {
        $priceTotal = null;
        $itemId = (int)$this->getRequest()->getPost('idItem');
        $qty = (int)$this->getRequest()->getPost('qty');

        $cartitems = $this->cart->getItems();
        foreach ($cartitems as $cartitem) {
            if ($cartitem->getProduct()->getId() == $itemId)
            {
                $price = (int)$cartitem->getPrice();
                $priceTotal = $price * $qty;
                $cartitem->setQty($qty)->setRowTotal($priceTotal)->save();
            }
        }
        //$resultJson = $this->resultJsonFactory->create(ResultFactory::TYPE_JSON);
        echo $priceTotal;
        
    }
}