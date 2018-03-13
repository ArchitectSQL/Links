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

use Magento\Framework\Model\AbstractModel;
use Magento\Backend\Helper\Js;

/**
 * Links Links mysql resource.
 */
class Grid extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected $_backendJsHelper;
    /**
     * @var string
     */
    //protected $_idFieldName = 'entity_id';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    protected $linksPages;

    protected $request;
    
    //protected $gridFactory;
    /**
     * Construct.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\Stdlib\DateTime\DateTime       $date
     * @param string|null                                       $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Web4pro\Links\Model\ResourceModel\LinksPages $linksPages,
        \Magento\Framework\App\Request\Http $request,
        Js $backendJsHelper
    
    ) {
        parent::__construct($context);
        $this->linksPages = $linksPages;
        //$this->gridFactory = $gridFactory;
        $this->request = $request;
        $this->_backendJsHelper = $backendJsHelper;
    }

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('web4pro_links', 'entity_id');
    }

    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
        {
            $pages = $this->request->getPostValue('pages');
            $pagesId = $this->_backendJsHelper->decodeGridSerializedInput($pages);
            $parentId = $object->getId();
            $connection = $this->getConnection();
            $bind = [':link_id' => (int)$parentId];
            $tableDependenceName = $this->linksPages->getMainTable();
            $select = $connection->select()->from(
                $tableDependenceName,
                ['id', 'page_id']
            )->where(
                'link_id = :link_id'
            );

            $links = $connection->fetchPairs($select, $bind);
            if (empty($links) && !empty($pagesId)) {
                    foreach($pagesId as $pageId){
                        $data [] = [
                            'page_id' => $pageId,
                            'link_id' => $parentId,
                        ];
                    }
                    $connection->insertMultiple($tableDependenceName, $data);

            } else {
                foreach ($pagesId as $pageId) {

                    if (!in_array($pageId, $links)) {
                        $dataInsert [] = [
                            'page_id' => $pageId,
                            'link_id' => $parentId,
                        ];

                    }
                }
                foreach ($links as $linkId => $linkValue) {
                    if (!in_array($linkValue, $pagesId)) {
                        $dataDelete [] = $linkId;
                    }
                }

                if(!empty($dataInsert)){
                    $connection->insertMultiple($tableDependenceName, $dataInsert);
                }
                if(!empty($dataDelete)){
                    $connection->delete($tableDependenceName, ['id IN (?)' => $dataDelete]);
                }
            }
            return parent::_afterSave($object);
        }
    
    
    /*public function getFullCollection($pageId)

    {   $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('\Web4pro\Links\Model\Grid');
        $ddd = $model->getCollection()->addFieldToSelect(['path','titlelink','status'])
        ->addFieldToFilter('status', 1)->
        getSelect()->joinLeft(
            array(
                'link' => 'links_cms_pages'),
            'main_table.link_id = link.link_id',
            array('page_id')
        )->where('link.page_id = '.$pageId);
        return $ddd;
    }*/
}
