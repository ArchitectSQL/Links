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
    protected $_objectManager;

    protected $_shipconfig;
    /**
     * Custom constructor.
     * @param Context $context
     * @param ResultFactory $resultJsonFactory
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Checkout\Model\Cart $cart
     */
    public function __construct(
        Context  $context,
        ResultFactory $resultJsonFactory,
        \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Shipping\Model\Config $shipconfig

    ) {
        $this->cart = $cart;
        $this->_shipconfig = $shipconfig;
        $this->_objectManager = $objectManager;
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
        $grandTotal = null;
        $summaryQtyProducts = null;
        $itemIdMinicart = null;

        $idProduct = (int)$this->getRequest()->getPost('idItem');
        $qty = (int)$this->getRequest()->getPost('qty');

        $cartItems = $this->cart->getItems();
        foreach ($cartItems as $cartItem) {

            if ($cartItem->getProduct()->getId() == $idProduct)
            {
                $itemIdMinicart = $cartItem->getItemId();
                $price = (int)$cartItem->getPrice();
                $priceTotal = $price * $qty;
                $cartItem->setQty($qty)->setRowTotal($priceTotal)->save();
            }
            $summaryQtyProducts += $cartItem->getQty();
            $grandTotal += $cartItem->getRowTotal();
        }

        $data = [
                    'priceTotal'        => $priceTotal,
                    'grandTotal'        => $grandTotal,
                    'summaryQtyProducts'=> $summaryQtyProducts,
                    'itemIdMinicart'=> $itemIdMinicart
                ];

        $resultJson = $this->resultJsonFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['data' => $data]);
        return $resultJson;

    }
}