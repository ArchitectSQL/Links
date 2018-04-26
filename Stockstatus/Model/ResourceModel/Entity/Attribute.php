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
namespace Web4pro\Stockstatus\Model\ResourceModel\Entity;

/**
 * Add option image in Database
 *
 * Class Attribute
 * @package Web4pro\Stockstatus\Model\ResourceModel\Entity
 */
class Attribute extends \Magento\Catalog\Model\ResourceModel\Attribute
{

    /**
     * @param \Magento\Framework\Model\AbstractModel $object
     * @param int $optionId
     * @param array $option
     * @return bool|int
     */
    protected function _updateAttributeOption($object, $optionId, $option)
    {
        $connection = $this->getConnection();
        $table = $this->getTable('eav_attribute_option');
        $intOptionId = (int)$optionId;

        if (!empty($option['delete'][$optionId])) {
            if ($intOptionId) {
                $connection->delete($table, ['option_id = ?' => $intOptionId]);
            }
            return false;
        }

        $image     = empty($option['image'][$optionId]) ? 0 : $option['image'][$optionId];
        $sortOrder = empty($option['order'][$optionId]) ? 0 : $option['order'][$optionId];
        if (!$intOptionId) {
            $data = ['attribute_id' => $object->getId(), 'sort_order' => $sortOrder, 'image' => $image];
            $connection->insert($table, $data);
            $intOptionId = $connection->lastInsertId($table);
        } else {
            $data = ['sort_order' => $sortOrder, 'image' => $image];
            $where = ['option_id = ?' => $intOptionId];
            $connection->update($table, $data, $where);
        }

        return $intOptionId;
    }
}