<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\PostRepositoryInterface;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory;

class Enable extends Action
{
    protected $_postRepository;

    protected $_filter;

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
        $postEnable = 0;
        foreach ($collection as $post){
//            $post->setId($post_id);
            if ($post->isActive() != 1)
            {
                $postEnable++;
            }
            $post->setIsActive(1);
            $this->_postRepository->save($post);
        }

        if ($postEnable) {
            $this->messageManager->addSuccessMessage(
                __('A total of %1 record(s) have been enable.', $postEnable)
            );
        }

        $this->_redirect('blog/post/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::postlist');
    }
}
