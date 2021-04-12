<?php
namespace OpenTechiz\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\App\ObjectManager;

class Comment extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('opentechiz_blog_comment', 'comment_id');
    }
}
