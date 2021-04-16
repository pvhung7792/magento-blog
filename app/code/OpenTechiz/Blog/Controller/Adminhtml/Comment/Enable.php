<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;

class Enable extends Action
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $_commentRepository;

    /**
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * Enable constructor.
     * @param Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CommentRepositoryInterface $commentRepository
     */
    public function __construct(Action\Context $context,
                                Filter $filter,
                                CollectionFactory $collectionFactory,
                                CommentRepositoryInterface $commentRepository)
    {
        $this->_commentRepository = $commentRepository;
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
//        $id = $this->getRequest()->getParam('selected');
        $collection = $this->_filter->getCollection($this->_collectionFactory->create() );
        $commentEnable = 0;
        foreach ($collection as $post){
//            $post->setId($post_id);
            if ($post->isActive() != 1){
                $commentEnable++;
            }
            $post->setIsActive(1);
            $this->_commentRepository->save($post);
        }
//        $this->_eventManager->dispatch("change_status_success", ['email' => ['email']]);
        if ($commentEnable) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been enable.', $commentEnable)
            );
        }

        $this->_redirect('blog/comment/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::comment');
    }
}
