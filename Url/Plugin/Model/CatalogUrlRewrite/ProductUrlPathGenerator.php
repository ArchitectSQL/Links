<?php

namespace Web4pro\Url\Plugin\Model\CatalogUrlRewrite;

//use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator

class ProductUrlPathGenerator 
{
   //const PRODUCT_PREFIX_ROUTE = 'shop/';
    //сonst CATEGORY_PREFIX_ROUTE = 'shop/category';
    
   protected $_scopeConfig;
   protected $_request;
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
        //var_dump($piecesPath);

        $pathProduct = array_pop($piecesPath);
        $pathCategory = array_pop($piecesPath);
            //if($pathProduct !== 'category')
        if($useRewriteUrlCategory === 1 && $useIsAnchor === 1)
        {
            return 'shop/'.$pathCategory.'/'.$pathProduct;
        } else {
            return 'shop/'. $pathProduct;
        }

    }
}