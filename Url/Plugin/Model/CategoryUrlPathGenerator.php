<?php
/**
 * Created by PhpStorm.
 * User: dev01
 * Date: 16.03.18
 * Time: 12:03
 */
namespace Web4pro\Url\Plugin\Model;

//use Web4pro\Url\Plugin\Model\CatalogUrlRewrite\ProductUrlPathGenerator;

class CategoryUrlPathGenerator
{
    /**
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $path)
    {

        if(strpos($path, 'shop/category1/') === false)
           $path = 'shop/category1/'. $path;
        return $path;
    }
}