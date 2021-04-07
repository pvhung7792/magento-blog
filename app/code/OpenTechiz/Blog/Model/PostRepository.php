<?php
namespace OpenTechiz\Blog\Model;

use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CustomManagement
 * @package ViMagento\CustomApi\Model
 */
class PostRepository implements \OpenTechiz\Blog\Api\PostRepositoryInterface
{
    /**
     * @var \OpenTechiz\Blog\Model\PostFactory
     */
    protected $postFactory;

    /**
     * @var ResourceModel\Post
     */
    protected $postResource;

    /**
     * @var ResourceModel\Post\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \OpenTechiz\Blog\Api\Data\PostSearchResultInterface
     */
    protected $postResultInterfaceFactory;

    /**
     * CustomRepository constructor.
     * @param \OpenTechiz\Blog\Model\PostFactory $postFactory
     * @param \OpenTechiz\Blog\Model\ResourceModel\Post $customResource
     * @param \OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory $collectionFactory
     * @param \OpenTechiz\Blog\Api\Data\PostSearchResultInterfaceFactory $postResultInterfaceFactory
     */
    public function __construct(
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Post $postResource,
        \OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory $collectionFactory,
        \OpenTechiz\Blog\Api\Data\PostSearchResultInterfaceFactory $postResultInterfaceFactory
    ) {
        $this->postFactory = $postFactory;
        $this->postResource = $postResource;
        $this->collectionFactory = $collectionFactory;
        $this->postResultInterfaceFactory = $postResultInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $postModel = $this->postFactory->create();
        $this->postResource->load($postModel, $id);
        if (!$postModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find post data with ID "%1"', $id));
        }
        return $postModel;
    }

    /**
     * {@inheritdoc}
     */
    public function save(PostInterface $blog)
    {
        $this->postResource->save($blog);
        return $blog;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            $postModel = $this->postFactory->create();
            $this->postResource->load($postModel, $id);
            $this->postResource->delete($postModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->postResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
