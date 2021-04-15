<?php
namespace OpenTechiz\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    protected $_commentRepository;

    protected $_dateTime;

    protected $_commentInterface;

    protected $_resultFactory;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                CommentRepositoryInterface $commentRepository,
                                DateTime $dateTime,
                                CommentInterface $commentInterface,
                                JsonFactory $jsonFactory
    )
    {
        $this->_dateTime = $dateTime;
        $this->_commentRepository = $commentRepository;
        $this->_commentInterface = $commentInterface;
        $this->_resultFactory = $jsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $comment = $this->_commentInterface;

        $comment->setUserId($data['user_id']);
        $comment->setContent($data['content']);
        $comment->setPostId($data['post_id']);
        /*$comment->setUserId(1);
        $comment->setContent('asdhasjhdg');
        $comment->setPostId(24);*/
        $comment->setIsActive(0);
        $comment->setCreationTime($this->_dateTime->gmtDate());

        $jsonResultFactory = $this->_resultFactory->create();

        try{
            $this->_commentRepository->save($comment);
            $message = "Your comment have been add success, plz wait for admin to approve";
            $jsonResultFactory->setData(['result'=>'success','message'=>$message]);
            $this->_eventManager->dispatch("customer_comment_success", ['email' => $data['email']]);
        }catch (\Exception $e){
//            $message = "Add comment fail";
            $message = $e->getMessage();
            $jsonResultFactory->setData(['result'=>'error','message'=>$message]);
        }

        /*$resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;*/
        return $jsonResultFactory;
    }
}
