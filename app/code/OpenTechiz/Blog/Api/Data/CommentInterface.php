<?php
namespace OpenTechiz\Blog\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Interface CustomInterface
 * @package OpenTechiz\Blog\Api\Data
 */

interface CommentInterface extends ExtensibleDataInterface
{
    const COMMENT_ID = 'comment_id';
    const POST_ID = 'post_id';
    const USER_ID = 'user_id';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const IS_ACTIVE = 'is_active';
    const CACHE_TAG = 'opentechiz_comment';

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getPostId();

    /**
     * @return int
     */
    public function getUserId();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return string
     */
    public function getCreationTime();

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
     * @param string $url_key
     * @return $this
     */
    public function setPostId($post_id);

    /**
     * @param int $user_id
     * @return $this
     */
    public function setUserId($user_id);

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
     * @param int $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get identities.
     * @return array
     */
    public function getIdentities();
}
