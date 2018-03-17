<?php
/**
 * Created by PhpStorm.
 * User: dev01
 * Date: 16.03.18
 * Time: 12:03
 */
namespace Web4pro\Url\Plugin\Model;

use Web4pro\Url\Model\CatalogUrlRewrite\ProductUrlPathGenerator;

class CategoryUrlPathGenerator
{
    /**
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $path)
    {
        //var_dump($subject);
        //var_dump($path);
        if(strpos($path, ProductUrlPathGenerator::CATEGORY_PREFIX_ROUTE) === false)
           $path = ProductUrlPathGenerator::CATEGORY_PREFIX_ROUTE . $path;
        //var_dump($path);//exit();
        return $path;
    }
}