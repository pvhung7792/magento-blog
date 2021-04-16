<?php

namespace OpenTechiz\Blog\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\DataObject\IdentityInterface;
/**
 * Class Post
 * @package OpenTechiz\Blog\Model
 */
class Comment extends AbstractExtensibleModel implements CommentInterface,IdentityInterface
{
    protected function _construct()
    {
        $this->_init(\OpenTechiz\Blog\Model\ResourceModel\Comment::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::COMMENT_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->getData(self::USER_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getPostId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->setData(self::COMMENT_ID, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserId($user_id)
    {
        $this->setData(self::USER_ID, $user_id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPostId($post_id)
    {
        $this->setData(self::POST_ID, $post_id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setContent($content)
    {
        $this->setData(self::CONTENT, $content);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreationTime($creationTime)
    {
        $this->setData(self::CREATION_TIME, $creationTime);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setIsActive($isActive)
    {
        $this->setData(self::IS_ACTIVE, $isActive);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
