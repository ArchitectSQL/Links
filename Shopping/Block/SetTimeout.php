<?php

namespace Web4pro\Shopping\Block;

class SetTimeout extends \Magento\Framework\View\Element\Template
{
    const TimeInJavaScript = 1000;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    /**
     * SetTimeout constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     */
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        parent::__construct($context);
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * @return integer
     */
    public function getTimeout()
    {
        $setTimeConfig = $this->_scopeConfig->getValue('web4proShoppingSec/general/display_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $setTimeout = $setTimeConfig * self::TimeInJavaScript;
        return $setTimeout;
    }
}