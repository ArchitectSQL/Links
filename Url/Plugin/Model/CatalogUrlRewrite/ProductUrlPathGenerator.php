<?php

namespace Web4pro\Url\Plugin\Model\CatalogUrlRewrite;

//use Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator

class ProductUrlPathGenerator 
{
   //const PRODUCT_PREFIX_ROUTE = 'shop/';
    //сonst CATEGORY_PREFIX_ROUTE = 'shop/category';
    
   
    /**
     * @param \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator $subject,$path)
    {
        $piecesPath = explode("/",$path);
        $pathProduct = array_pop($piecesPath);

            return 'shop/'. $pathProduct;
    }
}