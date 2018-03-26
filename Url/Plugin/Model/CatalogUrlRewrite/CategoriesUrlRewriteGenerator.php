<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Web4pro\Url\Plugin\Model\CatalogUrlRewrite;

class CategoriesUrlRewriteGenerator
{
    /**
     * @param \Magento\CatalogUrlRewrite\Model\Product\CategoriesUrlRewriteGenerator $subject
     * @param $url
     * @return array
     */
    public function afterGenerate(\Magento\CatalogUrlRewrite\Model\Product\CategoriesUrlRewriteGenerator $subject, $urls)
    {
        foreach ( $urls as $url) {
            $data = $url->_data;
            $piecesTargetPath = explode("/", $data['target_path']);
            $categoryId = array_pop($piecesTargetPath);
            
           $_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $category = $_objectManager->create('Magento\Catalog\Model\Category')
            ->load($categoryId);

            $categoryURLKey = $category->getURLKey();

            $piecesRequestPath = explode("/", $data['request_path']);
            $productPath = array_pop($piecesRequestPath);

            $url->_data['request_path'] = 'shop/'.$categoryURLKey.'/'.$productPath;
            $url->_data['target_path'] = 'shop/'.$categoryURLKey.'/'.$productPath;
        }
        
        return $urls;

    }
}
