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
namespace Web4pro\Stockstatus\Plugin\Block\Adminhtml\Wysiwyg\Images;

/**
 * Class Content
 * @package Web4pro\Stockstatus\Plugin\Block\Adminhtml\Wysiwyg\Images
 */
class Content
{
    /**
     * @var \Magento\Backend\Block\Widget\Container
     */
    protected $_container;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * Content constructor.
     * @param \Magento\Backend\Block\Widget\Container $container
     * @param \Magento\Framework\App\RequestInterface $request
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Container $container,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->_container = $container;
        $this->_request = $request;
    }

    /**
     * @return string
     */
    public function afterGetOnInsertUrl(\Magento\Cms\Block\Adminhtml\Wysiwyg\Images\Content $object, $result)
    {
        if($this->_request->getParam('static_urls_allowed')){
            return $this->_container->getUrl('cms/*/onInsert', array('static_urls_allowed' => 1));
        }

        return $this->_container->getUrl('cms/*/onInsert');
    }
}