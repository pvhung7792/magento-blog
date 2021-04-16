<?php
namespace OpenTechiz\Blog\Controller\Test;

use OpenTechiz\Blog\Cron\RemindAdmin;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    protected $_remindAdmin;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        RemindAdmin $remindAdmin
    )
    {
        $this->_pageFactory = $pageFactory;
        $this->_remindAdmin = $remindAdmin;
        return parent::__construct($context);
    }

    public function execute()
    {
        $this->_remindAdmin->sendMail();
    }
}
