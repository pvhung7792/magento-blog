<?php
namespace OpenTechiz\Blog\Observer;

use Magento\Framework\Event\Observer;

class CleanCache implements \Magento\Framework\Event\ObserverInterface
{
    private $fullPageCache;

    private function getCache()
    {
        if (!$this->fullPageCache) {
            $this->fullPageCache = \Magento\Framework\App\ObjectManager::getInstance()->get(
                \Magento\PageCache\Model\Cache\Type::class
            );
        }
        return $this->fullPageCache;
    }

    public function execute(Observer $observer)
    {
        $tags = $observer->getData('tag');
        $this->getCache()->clean(\Zend_Cache::CLEANING_MODE_MATCHING_TAG, $tags);
    }
}
