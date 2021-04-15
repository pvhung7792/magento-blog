<?php
namespace OpenTechiz\Blog\Controller\Comment;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Area;
use Magento\Store\Model\Store;
use Mageplaza\Smtp\Helper\Data as SmtpData;
use OpenTechiz\Blog\Api\CommentRepositoryInterface;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManager;

class Add extends Action
{
    protected $_commentRepository;

    protected $_dateTime;

    protected $_commentInterface;

    protected $_resultFactory;

    protected $_transportBuilder;

    protected $_scopeConfig;

    protected $_storeManager;

    public function __construct(\Magento\Framework\App\Action\Context $context,
                                CommentRepositoryInterface $commentRepository,
                                DateTime $dateTime,
                                CommentInterface $commentInterface,
                                JsonFactory $jsonFactory,
                                TransportBuilder $transportBuilder,
                                ScopeConfigInterface $scopeConfig,
                                StoreManager $storeManager
    )
    {
        $this->_dateTime = $dateTime;
        $this->_commentRepository = $commentRepository;
        $this->_commentInterface = $commentInterface;
        $this->_resultFactory = $jsonFactory;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $comment = $this->_commentInterface;

        $comment->setUserId($data['user_id']);
        $comment->setContent($data['content']);
        $comment->setPostId($data['post_id']);
        $comment->setIsActive(0);
        $comment->setCreationTime($this->_dateTime->gmtDate());

        $jsonResultFactory = $this->_resultFactory->create();

        try{
            $this->_commentRepository->save($comment);
            $message = "Your comment have been add success, plz wait for admin to approve";
            $jsonResultFactory->setData(['result'=>'success','message'=>$message]);
            /*$this->_eventManager->dispatch("customer_comment_success", ['email' => $data['email']]);*/
        }catch (\Exception $e){
            $message = $e->getMessage();
            $jsonResultFactory->setData(['result'=>'error','message'=>'Add comment fail '.$message]);
        }

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $transport = $this->_transportBuilder->setTemplateIdentifier($this->_scopeConfig->getValue('blog/general/template',$storeScope))
            ->setTemplateOptions(
                [
                    'area'=> \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store'=> $this->_storeManager->getStore()->getId()
                ]
            )
            ->setTemplateVars(['name'=>$data['first_name']])
            ->setFrom($this->_scopeConfig->getValue('blog/general/sender_email',$storeScope))
            ->addTo(['pvhung7792@gmail.com'])
            ->setReplyTo('pvhung7792@gmail.com')
            ->getTransport();
        $transport->sendMessage();
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
//        return $jsonResultFactory;
    }
}

