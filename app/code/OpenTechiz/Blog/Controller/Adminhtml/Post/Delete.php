<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\PostRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory;

class Delete extends Action
{
    /**
     * @var PostRepositoryInterface
     */
    protected $_postRepository;

    /**
     * @var Filter
     */
    protected  $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    public function __construct(Action\Context $context,
                                Filter $filter,
                                CollectionFactory $collectionFactory,
                                PostRepositoryInterface $postRepository)
    {
        $this->_postRepository = $postRepository;
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
            $this->_postRepository->deleteById($post->getId());
            $postDelete++;
        }
        if ($postDelete) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been delete.', $postDelete)
            );
        }
        $this->_redirect('blog/post/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::postlist');
    }
}
