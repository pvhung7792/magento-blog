<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;

class Delete extends Action
{
    /**
     * @var CommentRepositoryInterface
     */
    protected $_commentRepository;

    /**
     * @var Filter
     */
    protected  $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param CommentRepositoryInterface $commentRepositoryy
     */
    public function __construct(Action\Context $context,
                                Filter $filter,
                                CollectionFactory $collectionFactory,
                                CommentRepositoryInterface $commentRepositoryy)
    {
        $this->_commentRepository = $commentRepositoryy;
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
        $postDelete = 0;
        foreach ($collection as $post){
            $this->_commentRepository->deleteById($post->getId());
            $postDelete++;
        }
        if ($postDelete) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been delete.', $postDelete)
            );
        }
        $this->_redirect('blog/comment/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::post');
    }
}
