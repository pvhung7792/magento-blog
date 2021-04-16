<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

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
        $resultPage->addBreadcrumb(__('Blog'),__('Blog'));
        $resultPage->addBreadcrumb(__('Manage Blog'), __('Manage Blog'));
        $resultPage->getConfig()->getTitle()->prepend(__('Blog'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::postlist');
    }
}
