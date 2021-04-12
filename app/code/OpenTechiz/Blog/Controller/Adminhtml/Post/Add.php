<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Add extends \Magento\Backend\App\Action
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
        $resultPage->getConfig()->getTitle()->prepend(__('Add new Blog'));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::post');
    }
}
