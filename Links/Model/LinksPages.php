<?php

/**
 * Links Links Model.
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2017 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Web4pro\Links\Model;

class LinksPages extends \Magento\Framework\Model\AbstractModel
{

    protected function _construct()
    {
        $this->_init('Web4pro\Links\Model\ResourceModel\LinksPages');
    }
}