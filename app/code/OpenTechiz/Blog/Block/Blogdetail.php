<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\PostRepositoryInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Blogdetail extends \Magento\Framework\View\Element\Template implements IdentityInterface
{
    /**
     * @var PostRepositoryInterface
     */
    private $_postRepository;

    /**
     * Blogdetail constructor.
     * @param Template\Context $context
     * @param PostRepositoryInterface $postRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        PostRepositoryInterface $postRepository,
        array $data = [])
    {
        $this->_postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return \OpenTechiz\Blog\Api\Data\PostInterface
     */
    public function getBlogData()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $blog = $this->_postRepository->getById($post_id);

        return $blog;
    }

    public function getIdentities()
    {
        return $this->getBlogData()->getIdentities();
    }
}
