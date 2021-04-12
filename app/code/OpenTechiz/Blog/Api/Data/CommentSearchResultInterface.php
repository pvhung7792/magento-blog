<?php
namespace OpenTechiz\Blog\Api\Data;

/**
 * Interface PostSearchResultInterface
 * @package OpenTechiz\Blog\Api\Data
 */
interface CommentSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \OpenTechiz\Blog\Api\Data\CommentInterface[]
     */
    public function getItems();

    /**
     * @param \OpenTechiz\Blog\Api\Data\CommentInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
