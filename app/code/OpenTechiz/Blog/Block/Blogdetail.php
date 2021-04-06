<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\View\Element\Template;

class Blogdetail extends \Magento\Framework\View\Element\Template
{
    private $_postCollectionFactory;

    public function __construct(
        Template\Context $context,
        \OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
        array $data = [])
    {
        $this->_postCollectionFactory = $postCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getBlogData()
    {
//        $id = $this->getRequest()->getParam('id');
        $id = $this->_request->getParam('id');
//        $data = '';

        $collection = $this->_postCollectionFactory->create()->addFieldToFilter('post_id', $id)->getData();
        /*$data = $collection->load($id);
        foreach ($collection as $blog){
            if ($blog->getId() == $id){
                $data = $blog;
            }
        }
        $data = $collection->getItemByColumnValue('post_id',$id);*/
        return $collection;
    }
}
