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
    /*protected $categoryCollectionFactory;
    public function __construct (
                    \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
    ) {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }*/
    /**
     * @param \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject
     * @param $path
     * @return string
     */
    public function afterGetUrlPath(\Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator $subject, $path)
    {
        //var_dump($path);

            if (!empty($path))
            {
                if (strpos($path, 'shop/category') === false)
                {
                    $path = 'shop/category/' . $path;
                }
            }
        //var_dump($path);
        return $path;
    }
}