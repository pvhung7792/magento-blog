<?php
namespace OpenTechiz\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    protected $_commentRepository;

    protected $_dateTime;

    protected $_commentInterface;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                CommentRepositoryInterface $commentRepository,
                                DateTime $dateTime,
                                CommentInterface $commentInterface
    )
    {
        $this->_dateTime = $dateTime;
        $this->_commentRepository = $commentRepository;
        $this->_commentInterface = $commentInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $comment = $this->_commentInterface;

        $comment->setUserName($data['user_name']);
        $comment->setContent($data['content']);
        $comment->setPostId($data['post_id']);
        $comment->setIsActive(1);
        $comment->setCreationTime($this->_dateTime->gmtDate());

        try{
            $this->_commentRepository->save($comment);
        }catch (\Exception $e){
            $this->messageManager->addErrorMessage(__('Add comment fail'));
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
//        $this->_redirect('blog/index/index');
    }
}
