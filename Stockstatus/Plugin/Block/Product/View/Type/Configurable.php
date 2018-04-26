<?php
/**
 * WEB4PRO - Creating profitable online stores
 *
 * @author    ekapelko@corp.web4pro.com.ua
 * @category  WEB4PRO
 * @package   Web4pro_Stockstatus
 * @copyright Copyright (c) 2017 WEB4PRO (http://www.web4pro.net)
 * @license   http://www.web4pro.net/license.txt
 */
namespace Web4pro\Stockstatus\Plugin\Block\Product\View\Type;

class Configurable 
{
    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var \Magento\Framework\Json\DecoderInterface
     */
    protected $jsonDecoder;

    /**
     * @var \Web4pro\Stockstatus\Helper\Data
     */
    protected $_help;

    /**
     * Configurable constructor.
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Framework\Json\DecoderInterface $jsonDecoder
     * @param \Web4pro\Stockstatus\Helper\Data $helper
     */
    public function __construct(\Magento\Framework\Json\EncoderInterface $jsonEncoder,
                                \Magento\Framework\Json\DecoderInterface $jsonDecoder,
                                \Web4pro\Stockstatus\Helper\Data $helper)
    {
        $this->jsonEncoder = $jsonEncoder;
        $this->jsonDecoder = $jsonDecoder;
        $this->_help = $helper;
    }

    /**
     * @param \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject
     * @param $result
     * @return string
     */
    public function afterGetJsonConfig(\Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject,
                                        $result)
    {   
        $decode = $this->jsonDecoder->decode($result);
        foreach ($decode['attributes'] as &$attribute) {
            foreach ($attribute['options'] as &$option) {
                $thisProduct = false;
                $products = $subject->getAllowProducts();
                $stockStatusDefult = ['is_in_stock' => true];
                foreach ($products as $product)
                {
                   if ($product->getId() == $option['products'][0])
                   {
                       $product->setData('quantity_and_stock_status',$stockStatusDefult);
                       $thisProduct = $product;
                       break;
                   }
                }
                $price = number_format($thisProduct['price'], 2, '.', '');
                $stockStatus = $this->_help->getNewStockStatusOptions($thisProduct);
                $labelOld = $option['label'];
                $newStatus = $labelOld.'  ('.$stockStatus.')   +$'.$price;
                $option['label'] = $newStatus;
            }
        }
        return $this->jsonEncoder->encode($decode);
    }
}