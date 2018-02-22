<?php
/**
 * Webkul_Grid Status Options Model.
 * @category    Web4pro
 * @author      Web4pro Software Private Limited
 */
namespace Web4pro\Links\Model;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * Get Links row status type labels array.
     * @return array
     */
    public function getOptionArray()
    {
        $options = ['1' => __('Enabled'),'0' => __('Disabled')];
        return $options;
    }

    /**
     * Get Links row status labels array with empty value for option element.
     *
     * @return array
     */
    public function getAllOptions()
    {
        $res = $this->getOptions();
        array_unshift($res, ['value' => '', 'label' => '']);
        return $res;
    }

    /**
     * Get Links row type array for option element.
     * @return array
     */
    public function getOptions()
    {
        $res = [];
        foreach ($this->getOptionArray() as $index => $value) {
            $res[] = ['value' => $index, 'label' => $value];
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return $this->getOptions();
    }
}
