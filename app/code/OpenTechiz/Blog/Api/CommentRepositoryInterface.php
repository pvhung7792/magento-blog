<?php
namespace OpenTechiz\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use OpenTechiz\Blog\Api\Data\CommentInterface;

/**
 * Interface PostRepositoryInterface
 * @package OpenTechiz\Blog\Api
 */

interface CommentRepositoryInterface
{
    /**
     * @param int $id
     * @return \OpenTechiz\Blog\Api\Data\CommentInterface
     */
    public function getById($id);

    /**
     * @param \OpenTechiz\Blog\Api\Data\CommentInterface $comment
     * @return \OpenTechiz\Blog\Api\Data\CommentInterface
     */
    public function save(CommentInterface $comment);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \OpenTechiz\Blog\Api\Data\CommentRepositoryInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

}
