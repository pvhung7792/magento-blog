<?php
namespace OpenTechiz\Blog\Helper;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use OpenTechiz\Blog\Api\PostRepositoryInterface;

class Post extends AbstractHelper
{
    /**
    * @var PostRepositoryInterface
    */
    protected $postRepository;

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
        \Magento\Framework\App\Helper\Context $context,
        PostRepositoryInterface $postRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
    }

    public function getPosts() {
        $filter1 = $this->filterBuilder->setField('member')
                                    ->setValue(1)
                                    ->setConditionType('neq')
                                    ->create();
        $filter2 = $this->filterBuilder->setField('member')
                                    ->setValue('')
                                    ->setConditionType('eq')
                                    ->create();

        $filterOr = $this->filterGroupBuilder->addFilter($filter1)
                                            ->addFilter($filter2)
                                            ->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filterOr]);

        $posts = $this->postRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return $posts;
    }
}
