<?php
/**
 * Links Links ResourceModel.
 * @category  Web4pro
 * @package   Webkul_Grid
 * @author    Web4pro
 * @copyright Copyright (c) 2010-2016 Web4pro Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Web4pro\Links\Model\ResourceModel;

/**
 * Links Links mysql resource.
 */
class LinksPages extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime       $date
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('links_cms_pages', 'id');
    }
}