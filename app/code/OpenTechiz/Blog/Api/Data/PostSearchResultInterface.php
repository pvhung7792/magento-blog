<?php
namespace OpenTechiz\Blog\Api\Data;

/**
 * Interface PostSearchResultInterface
 * @package OpenTechiz\Blog\Api\Data
 */
interface PostSearchResultInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @return \OpenTechiz\Blog\Api\Data\PostInterface[]
     */
    public function getItems();

    /**
     * @param \OpenTechiz\Blog\Api\Data\PostInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
