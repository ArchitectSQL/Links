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
class Grid extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    protected $linksPages;

    protected $request;
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
        \Web4pro\Links\Model\LinksPagesFactory $linksPages,
        \Magento\Framework\App\Request\Http $request,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
        $this->_date = $date;
        $this->linksPages = $linksPages;
        $this->request = $request;
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

        $data = $this->request->getPost();
        //var_dump($object->getEntityId());exit();
        $idLink = $object->getEntityId();
        $modelLP = $this->linksPages->create();
        $pages = $data['pages'];
        array_shift($pages);
        foreach ($pages as $key => $idPage) {
            $linkPage = [
                'link_id' => $idLink,
                'page_id' => $idPage
            ];
            $modelLP->setData($linkPage);
            $modelLP->save();
        }


    }
}
