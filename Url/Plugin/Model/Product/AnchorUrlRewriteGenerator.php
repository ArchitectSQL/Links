<?php

namespace Web4pro\Url\Plugin\Model\Product;

class AnchorUrlRewriteGenerator
{
    public function afterGenerate(\Magento\CatalogUrlRewrite\Model\Product\AnchorUrlRewriteGenerator $subject,$url)
    {
        $urlAnchor[] = $url['request_path'];
        //var_dump($urlAnchor);exit();
        return $urlAnchor;
    }
}