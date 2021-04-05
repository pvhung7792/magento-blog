<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;


class Bloglist extends \Magento\Framework\View\Element\Template
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

    /*public function getBlogData()
    {
        $collection = $this->_postCollectionFactory->create();
        return $collection;
    }*/
    public function getBlogs()
    {
        if (!$this->hasData('posts')) {
            $post = $this->_postCollectionFactory
                        ->create()
                        ->addFilter('is_active', 1)
                        ->addOrder(
                            PostInterface::CREATION_TIME,
                            PostCollection::SORT_ORDER_DESC
                        );
            $this->setData('posts',$post);
        }
        return $this->getData('posts');
    }

    public function makeUrl($param)
    {
        return $this->getUrl('blog/view', ['id'=>$param]);
    }
}
