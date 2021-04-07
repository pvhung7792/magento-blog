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
        $id = $this->getRequest()->getParam('id');
        try {
            $blog = $this->_postRepository->getById($id);
        }catch (NoSuchEntityException $e){
            echo 'alsdj';
            exit();
        }

        return $blog;
    }
}
