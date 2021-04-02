<?php
namespace OpenTechiz\Blog\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use OpenTechiz\Blog\Api\Data\PostInterface;

/**
 * Interface PostRepositoryInterface
 * @package OpenTechiz\Blog\Api
 */

interface PostRepositoryInterface
{
    /**
     * @param int $id
     * @return \OpenTechiz\Blog\Api\Data\PostInterface
     */
    public function getById($id);

    /**
     * @param \OpenTechiz\Blog\Api\Data\PostInterface $blog
     * @return \OpenTechiz\Blog\Api\Data\PostInterface
     */
    public function save(PostInterface $blog);

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById($id);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \OpenTechiz\Blog\Api\Data\PostRepositoryInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
