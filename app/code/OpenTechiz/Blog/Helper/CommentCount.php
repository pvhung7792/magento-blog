<?php
namespace OpenTechiz\Blog\Helper;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;

class CommentCount
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

    public function __construct(
        CommentRepositoryInterface $commentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder
    ) {
        $this->commentRepository = $commentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\InputException
     */

    public function countCommentInActive()
    {
        $filterInActive = $this->filterBuilder->setField('main_table.is_active')
            ->setValue(0)
            ->setConditionType('eq')
            ->create();

        $filterInActive = $this->filterGroupBuilder->setFilters([$filterInActive])->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filterInActive]);

        $commentList = $this->commentRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return count($commentList);
    }

}
