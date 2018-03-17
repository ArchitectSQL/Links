<?php

namespace Web4pro\Url\Model\CatalogUrlRewrite;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Class ProductUrlPathGenerator
 * @package Web4pro\Url\Model\CatalogUrlRewrite
 */
class ProductUrlPathGenerator extends \Magento\CatalogUrlRewrite\Model\ProductUrlPathGenerator
{
    const PRODUCT_PREFIX_ROUTE = 'shop/';
    const CATEGORY_PREFIX_ROUTE = 'shop/category';

    /**
     * ProductUrlPathGenerator constructor.
     * @param StoreManagerInterface $storeManager
     * @param ScopeConfigInterface $scopeConfig
     * @param CategoryUrlPathGenerator $categoryUrlPathGenerator
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(StoreManagerInterface $storeManager,
                                ScopeConfigInterface $scopeConfig,
                                CategoryUrlPathGenerator $categoryUrlPathGenerator,
                                ProductRepositoryInterface $productRepository)
    {
        parent::__construct($storeManager,$scopeConfig,$categoryUrlPathGenerator,$productRepository);
    }

    /**
     * @param \Magento\Catalog\Model\Product $product
     * @param null $category
     * @return string
     */
    public function getUrlPath($product , $category = null)
    {
        //exit();
        $path = $product->getData('url_path');
        //var_dump($path);exit();
        if ($path === null)
        {
            $path = $product->getUrlKey() ? $this->prepareProductUrlKey($product) : $this->prepareProductDefaultUrlKey($product);
        }

        if ($category !== null)
        {
            $categoryUrl = str_replace(self::CATEGORY_PREFIX_ROUTE.'/','',$this->categoryUrlPathGenerator->getUrlPath($category));
            $path = $categoryUrl . '/' . $path;
        }
        //var_dump($path);
        return self::PRODUCT_PREFIX_ROUTE . $path;
    }
}