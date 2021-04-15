<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\PostRepositoryInterface;
class Bloglist extends \Magento\Framework\View\Element\Template
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
        Template\Context $context,
        PostRepositoryInterface $postRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder
    ) {
        parent::__construct($context);
        $this->postRepository = $postRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
    }
    /*public function getBlogData()
    {
        $collection = $this->_postCollectionFactory->create();
        return $collection;
    }*/
    public function getBlogs()
    {
        $filter = $this->filterBuilder->setField('is_active')
            ->setValue(1)
            ->setConditionType('eq')
            ->create();

        $filterOr = $this->filterGroupBuilder->addFilter($filter)->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filterOr]);

        $bloglist = $this->postRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return $bloglist;
    }

}
