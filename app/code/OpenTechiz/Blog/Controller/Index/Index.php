<?php
namespace OpenTechiz\Blog\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $pageResult = $this->_pageFactory->create();
        $pageResult->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0', true);
        return $pageResult;
    }
}
