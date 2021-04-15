<?php
namespace OpenTechiz\Blog\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'comment_id';

    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Comment', 'OpenTechiz\Blog\Model\ResourceModel\Comment');
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        $this->getSelect()->joinLeft(
            ['postTable' => $this->getTable('opentechiz_blog_post')],
            'main_table.post_id = postTable.post_id',
            ['title'=>'postTable.title']
        );
    }
}
