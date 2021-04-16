<?php
namespace OpenTechiz\Blog\Model;

use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CustomManagement
 * @package ViMagento\CustomApi\Model
 */
class CommentRepository implements \OpenTechiz\Blog\Api\CommentRepositoryInterface
{
    /**
     * @var \OpenTechiz\Blog\Model\CommentFactory
     */
    protected $commentFactory;

    /**
     * @var ResourceModel\Comment
     */
    protected $commentResource;

    /**
     * @var ResourceModel\Comment\CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var \OpenTechiz\Blog\Api\Data\CommentSearchResultInterface
     */
    protected $commentResultInterfaceFactory;

    /**
     * CustomRepository constructor.
     * @param \OpenTechiz\Blog\Model\CommentFactory $commentFactory
     * @param \OpenTechiz\Blog\Model\ResourceModel\Comment $commentResource
     * @param \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $collectionFactory
     * @param \OpenTechiz\Blog\Api\Data\CommentSearchResultInterface $commentResultInterfaceFactory
     */
    public function __construct(
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Comment $commentResource,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $collectionFactory,
        \OpenTechiz\Blog\Api\Data\CommentSearchResultInterfaceFactory $commentResultInterfaceFactory
    ) {
        $this->commentFactory = $commentFactory;
        $this->commentResource = $commentResource;
        $this->collectionFactory = $collectionFactory;
        $this->commentResultInterfaceFactory = $commentResultInterfaceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($id)
    {
        $postModel = $this->commentFactory->create();
        $this->commentResource->load($postModel, $id);
        if (!$postModel->getId()) {
            throw new NoSuchEntityException(__('Unable to find post data with ID "%1"', $id));
        }
        return $postModel;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CommentInterface $comment)
    {
        $this->commentResource->save($comment);
        return $comment;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($id)
    {
        try {
            $postModel = $this->commentFactory->create();
            $this->commentResource->load($postModel, $id);
            $this->commentResource->delete($postModel);
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
        $searchResults = $this->commentResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

}
