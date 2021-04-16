<?php
namespace OpenTechiz\Blog\Helper;

use Magento\Framework\App\Area;
use Magento\Store\Model\Store;
use Mageplaza\Smtp\Helper\Data as SmtpData;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManager;

class Email
{
    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var StoreManager
     */
    protected $_storeManager;


    public function __construct(
        TransportBuilder $transportBuilder,
        ScopeConfigInterface $scopeConfig,
        StoreManager $storeManager
    )
    {
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager = $storeManager;
    }

    /**
     * @param $reviceEmail
     * @param array $templateValues
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\MailException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function sendMail($reviceEmail,array $templateValues)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

        $transport = $this->_transportBuilder->setTemplateIdentifier($this->_scopeConfig->getValue('blog/general/template',$storeScope))
            ->setTemplateOptions(
                [
                    'area'=> \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store'=> $this->_storeManager->getStore()->getId()
                ]
            )
            ->setTemplateVars($templateValues)
            ->setFrom($this->_scopeConfig->getValue('blog/general/sender_email',$storeScope))
            ->addTo([$reviceEmail])
            ->setReplyTo($reviceEmail)
            ->getTransport();

        $transport->sendMessage();
    }
}
