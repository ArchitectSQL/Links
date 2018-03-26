<?php
/**
 * Created by PhpStorm.
 * User: dev01
 * Date: 16.03.18
 * Time: 12:03
 */
namespace Web4pro\Url\Plugin\Model\Product;


class Url
{
    /**
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function aroundGetUrl(\Magento\Catalog\Model\Product\Url $subject,
                                \Closure $proceed,
                                $product)
    {
        $originalResult = $proceed($product);
        //var_dump($product);
        //var_dump($originalResult);
        return $product->getUrlKey().'.html';
    }
}