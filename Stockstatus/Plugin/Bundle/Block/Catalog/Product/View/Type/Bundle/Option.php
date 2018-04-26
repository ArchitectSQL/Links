<?php
/**
 * WEB4PRO - Creating profitable online stores
 *
 * @author    vyurchenko@corp.web4pro.com.ua
 * @category  WEB4PRO
 * @package   Web4pro_Stockstatus
 * @copyright Copyright (c) 2017 WEB4PRO (http://www.web4pro.net)
 * @license   http://www.web4pro.net/license.txt
*/
namespace Web4pro\Stockstatus\Plugin\Bundle\Block\Catalog\Product\View\Type\Bundle;

use \Web4pro\Stockstatus\Helper\Data as Stockstatus;

/**
 * Class Option
 * @package Web4pro\Stockstatus\Plugin\Bundle\Block\Catalog\Product\View\Type\Bundle
 */
class Option
{
    /**
     * @var Stockstatus
     */
    protected $_helper;

    /**
     * Option constructor.
     * @param Stockstatus $_helper
     */
    public function __construct(Stockstatus $_helper)
    {
        $this->_helper = $_helper;
    }

    /**
     * @param \Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option $object
     * @param \Closure $closure
     * @param \Magento\Catalog\Model\Product $selection
     * @param bool $includeContainer
     * @return string
     */
    public function aroundGetSelectionTitlePrice(
        \Magento\Bundle\Block\Catalog\Product\View\Type\Bundle\Option $object,
        \Closure $closure,
        \Magento\Catalog\Model\Product $selection,
        $includeContainer = true
    )
    {
        $stockstatus = $this->_helper->getStockStatusForProduct($selection, 'bundle');

        $priceTitle = '<span class="product-name">' . $object->escapeHtml($selection->getName()) . '</span>';
        $priceTitle .= ' &nbsp; ' . ($includeContainer ? '<span class="price-notice">' : '') . '+'
            . $object->renderPriceString($selection, $includeContainer) . ($includeContainer ? '</span>' : '');
        return $priceTitle . $stockstatus;
    }
}