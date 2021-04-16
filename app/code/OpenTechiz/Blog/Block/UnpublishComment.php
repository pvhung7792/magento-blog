<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Customer\Api\CustomerRepositoryInterface;

class UnpublishComment extends \Magento\Framework\View\Element\Template
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

    /**
     * @var CustomerRepositoryInterface
     */
    protected $_customerRepositoryInterface;

    public function __construct(
        Template\Context $context,
        CommentRepositoryInterface $commentRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        FilterBuilder $filterBuilder,
        SortOrder $sortOrder,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context);
        $this->commentRepository = $commentRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrder = $sortOrder;
        $this->_customerRepositoryInterface = $customerRepository;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\InputException
     */

    public function getComments()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $customer_id = $this->getCustomer()->getId();

        $filterIsActive = $this->filterBuilder->setField('main_table.is_active')
            ->setValue(2)
            ->setConditionType('eq')
            ->create();

        $filterByPostId = $this->filterBuilder->setField('main_table.post_id')
            ->setValue($post_id)
            ->setConditionType('eq')
            ->create();

        $filterByUserId = $this->filterBuilder->setField('main_table.user_id')
            ->setValue($customer_id)
            ->setConditionType('eq')
            ->create();

        $this->sortOrder->setField('creation_time')
            ->setDirection('DESC');

        $filterByPostId = $this->filterGroupBuilder->setFilters([$filterByPostId])->create();
        $filterIsActive = $this->filterGroupBuilder->setFilters([$filterIsActive])->create();
        $filterByUserId = $this->filterGroupBuilder->setFilters([$filterByUserId])->create();

        $this->searchCriteriaBuilder->setFilterGroups([$filterByPostId,$filterIsActive,$filterByUserId]);
        $this->searchCriteriaBuilder->setSortOrders([$this->sortOrder]);

        $commentList = $this->commentRepository->getList($this->searchCriteriaBuilder->create())->getItems();

        return $commentList;
    }

    public function isLogin()
    {
        $om = \Magento\Framework\App\ObjectManager::getInstance();
        /** @var \Magento\Framework\App\Http\Context $context */
        $context = $om->get('Magento\Framework\App\Http\Context');
        /** @var bool $isLoggedIn */
        return $isLoggedIn = $context->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    /**
     * @return \Magento\Customer\Model\Customer
     */

    public function getCustomer()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        return $customerSession->getCustomer();
    }

    /**
     * @param $id
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */

    public function getCustomerNameById($id)
    {
        $customer = $this->_customerRepositoryInterface->getById($id);
        return $customer->getFirstname().' '.$customer->getlastname();
    }
}
