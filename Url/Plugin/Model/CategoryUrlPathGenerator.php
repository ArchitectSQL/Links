<?php
/**
 * Created by PhpStorm.
 * User: dev01
 * Date: 16.03.18
 * Time: 12:03
 */
namespace Web4pro\Url\Plugin\Model;

class CategoryUrlPathGenerator
{
    /**
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $path)
    {
            if (!empty($path))
            {
                if (strpos($path, 'shop/category') === false)
                {
                    $path = 'shop/category/' . $path;
                }
            }
        return $path;
    }
}