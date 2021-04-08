<?php
namespace OpenTechiz\Blog\Block;

use Magento\Framework\View\Element\Template;
use OpenTechiz\Blog\Api\PostRepositoryInterface;

class Blogdetail extends \Magento\Framework\View\Element\Template
{
    private $_postRepository;

    public function __construct(
        Template\Context $context,
        PostRepositoryInterface $postRepository,
        array $data = [])
    {
        $this->_postRepository = $postRepository;
        parent::__construct($context, $data);
    }

    public function getBlogData()
    {
        $post_id = $this->getRequest()->getParam('post_id');
        $blog = $this->_postRepository->getById($post_id);

        return $blog;
    }
}
