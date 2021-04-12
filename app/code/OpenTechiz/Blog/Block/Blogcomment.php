<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use Magento\Framework\Api\SortOrder;

class Blogcomment extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $commentRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @var FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var SortOrder
     */
    protected $sortOrder;

    public function __construct(
        Template\Context $context,
        CommentRepositoryInterface $commentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
        SortOrder $sortOrder
    ) {
        parent::__construct($context);
        $this->commentRepository = $commentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrder = $sortOrder;
    }

    public function getComments()
    {
        $post_id = $this->getRequest()->getParam('post_id');

        $filterIsActive = $this->filterBuilder->setField('is_active')
            ->setValue(1)
            ->setConditionType('eq')
            ->create();

        $filterByPostId = $this->filterBuilder->setField('post_id')
            ->setValue($post_id)
            ->setConditionType('eq')
            ->create();

        $this->sortOrder->setField('creation_time')
                        ->setDirection('DESC');

        $filterByPostId = $this->filterGroupBuilder->setFilters([$filterByPostId])->create();
        $filterIsActive = $this->filterGroupBuilder->setFilters([$filterIsActive])->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filterByPostId,$filterIsActive]);
        $this->searchCriteriaBuilder->setSortOrders([$this->sortOrder]);

        $commentList = $this->commentRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return $commentList;
    }

    public function getPostId()
    {
        return $this->getRequest()->getParam('post_id');
    }

    public function getFormAction()
    {
        return 'blog/comment/add';
    }
}
