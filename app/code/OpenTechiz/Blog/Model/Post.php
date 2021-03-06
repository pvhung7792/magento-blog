<?php

namespace OpenTechiz\Blog\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use OpenTechiz\Blog\Api\Data\PostInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Post
 * @package OpenTechiz\Blog\Model
 */
class Post extends AbstractExtensibleModel implements PostInterface,IdentityInterface
{
    /*const POST_ID = 'post_id';
    const URL_KEY = 'url_key';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';*/

    protected function _construct()
    {
        $this->_init(\OpenTechiz\Blog\Model\ResourceModel\Post::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::POST_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
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
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
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
        $this->setData(self::POST_ID, $id);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUrlKey($url_key)
    {
        $this->setData(self::URL_KEY, $url_key);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUrl()
    {
        return "/view/".$this->_getData(self::URL_KEY).".html";
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        $this->setData(self::TITLE, $title);
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
    public function setUpdateTime($updateTime)
    {
        $this->setData(self::UPDATE_TIME, $updateTime);
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
    public function checkUrlKey($url_key)
    {
        return $this->_getResource()->checkUrlKey($url_key);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
