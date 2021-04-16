<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends \Magento\Backend\App\Action
{
    protected $_pageFactory;

    public function __construct(Action\Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }


    public function execute()
    {
        $resultPage = $this->_pageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_BLog::blog');
        $resultPage->addBreadcrumb(__('Comment'),__('Comment'));
        $resultPage->addBreadcrumb(__('Manage Comment'), __('Manage Comment'));
        $resultPage->getConfig()->getTitle()->prepend(__('Comment'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::comment');
    }
}
