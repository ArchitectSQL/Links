<?php

namespace Web4pro\Url\Plugin\Model\CatalogUrlRewrite;


class ProductUrlPathGenerator 
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
   protected $_scopeConfig;
    /**
     * @var \Magento\Framework\App\Request\Http
     */
   protected $_request;

    /**
     * ProductUrlPathGenerator constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Request\Http $request
     */
   public function __construct(
       \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Request\Http $request
   ) {
       $this->_scopeConfig = $scopeConfig;
       $this->_request = $request;
   }
    /**
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject,$path)
    {
        $useRewriteUrlCategory = (int)$this->_scopeConfig->getValue('catalog/seo/product_use_categories', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $useIsAnchor = (int)$this->_request->getPost('is_anchor');
        $piecesPath = explode("/",$path);

        $pathProduct = array_pop($piecesPath);
        $pathCategory = array_pop($piecesPath);

        if($useRewriteUrlCategory === 1 && $useIsAnchor === 1 && $pathCategory)
        {
            return 'shop/'.$pathCategory.'/'.$pathProduct;
        } else {
            return 'shop/'. $pathProduct;
        }

    }
}