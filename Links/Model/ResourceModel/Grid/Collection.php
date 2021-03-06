<?php

/**
 * Links Links Collection.
 *
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2017 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Web4pro\Links\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */

    protected function _construct(
    )
    {
        $this->_init(
            'Web4pro\Links\Model\Grid',
            'Web4pro\Links\Model\ResourceModel\Grid'
        );
    }
    

}
