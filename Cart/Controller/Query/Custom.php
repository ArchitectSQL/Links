<?php
namespace Web4pro\Cart\Controller\Query;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\ObjectManager;
use Magento\Quote\Model\Quote\Address\RateCollectorInterface;
use Magento\Quote\Model\Quote\Address\RateRequestFactory;
use Magento\Sales\Model\Order\Shipment;

class Custom extends \Magento\Framework\App\Action\Action
{
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

    /**
     * @var \Magento\Shipping\Model\Shipping
     */
    protected $_shipping;

    protected $_checkoutCart;
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
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Shipping\Model\Shipping $shipping,
        \Magento\Checkout\Controller\Cart\UpdatePost $checkoutCart

    ) {
        $this->_checkoutCart = $checkoutCart;
        $this->_shipping = $shipping;
        $this->cart = $cart;
        $this->_checkoutSession = $checkoutSession;
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @param \Magento\Framework\Controller\ResultInterface
     * @return array
     */
    public function execute()
    {
        $priceTotal = null;
        $summaryQtyProducts = null;
        $itemIdMinicart = null;

        $idProduct = (int)$this->getRequest()->getPost('item_id');
        $qty = (int)$this->getRequest()->getPost('item_qty');

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
        }
        $this->_checkoutCart->_updateShoppingCart();


        
        $session = $this->_checkoutSession;
        $address = $session->getQuote()->getShippingAddress();

        $shippingTax = $this->_shipping->collectRatesByAddress($address)->getResult();
        $shippingPrice = $shippingTax->_rates[0]->getPrice();
        //$orderTotal = $grandTotal + $shippingPrice;

        $data = [
                    'priceTotal'        => sprintf("%.2f" , $priceTotal),
                    //'grandTotal'        => sprintf("%.2f" , $grandTotal),
                    'summaryQtyProducts'=> $summaryQtyProducts,
                    'itemIdMinicart'    => $itemIdMinicart,
                    //'shippingPrice'     => sprintf("%.2f" , $shippingPrice)
                    //'orderTotal'        => sprintf("%.2f" , $orderTotal)
                ];

        $resultJson = $this->resultJsonFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['data' => $data]);
        return $resultJson;

    }
}