<?php
namespace OpenTechiz\Blog\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Interface CustomInterface
 * @package OpenTechiz\Blog\Api\Data
 */

interface PostInterface extends ExtensibleDataInterface
{
    const POST_ID = 'post_id';
    const URL_KEY = 'url_key';
    const TITLE = 'title';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getUrlKey();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getCreationTime();

    /**
     * @return string
     */
    public function getUpdateTime();

    /**
     * @return int
     */
    public function isActive();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @param integer $modelId
     * @param null|string $field
     * @return $this
     */
    public function load($modelId, $field = null);

    /**
     * @param string $url_key
     * @return $this
     */
    public function setUrlKey($url_key);

//    public function getUrl();

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content);

    /**
     * @param string $creationTime
     * @return $this
     */
    public function setCreationTime($creationTime);

    /**
     * @param string $updateTime
     * @return $this
     */
    public function setUpdateTime($updateTime);

    /**
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);
}
