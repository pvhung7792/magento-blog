<?php
namespace OpenTechiz\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use OpenTechiz\Blog\Helper\Email;


class CustomerComment implements ObserverInterface
{
    private $helperEmail;

    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $email = $observer->getData('email');
        return $this->helperEmail->sendEmail($email);
    }
}
