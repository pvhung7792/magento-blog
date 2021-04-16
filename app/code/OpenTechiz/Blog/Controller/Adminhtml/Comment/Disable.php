<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;

class Disable extends Action
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
     * Disable constructor.
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
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $commentDisable = 0;
        $cacheTags = [];
        foreach($collection as $comment){
//            $post->setId($post_id);
            if ($comment->isActive() != 0){
                $commentDisable++;
                $cacheTags[] = $comment->getIdentities();
            }

            $comment->setIsActive(0);
            $this->_commentRepository->save($comment);
        }
        if (!empty($cacheTags)){
            $this->_eventManager->dispatch("change_status_success", ['tag' => $cacheTags]);
        }
        if ($commentDisable) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been disable.', $commentDisable)
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
