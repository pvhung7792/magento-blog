<?php
namespace OpenTechiz\Blog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\App\ObjectManager;

class Post extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('opentechiz_blog_post', 'post_id');
    }

    public function checkUrlKey($url_key)
    {
        $connection = $this->getConnection();
        $tableName= $this->_mainTable;

        $sql = $connection->select()->from($tableName, array('*'))->where('url_key=?',$url_key);
        $colResult = $connection->fetchCol($sql);

        // echo ($sql->__toString() );
        if  (count($colResult)==0) return false;
        return $colResult[0];
    }
}
