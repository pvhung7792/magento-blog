<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Api\PostRepositoryInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use OpenTechiz\Blog\Api\Data\PostInterface;

class Save extends Action
{
    protected $_postRepository;

    protected $_dateTime;

    protected $_postInterface;

    public function __construct(Action\Context $context,
                                PostRepositoryInterface $postRepository,
                                DateTime $dateTime,
                                PostInterface $postInterface
    )
    {
        $this->_dateTime = $dateTime;
        $this->_postRepository = $postRepository;
        $this->_postInterface = $postInterface;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['post_id']) ? $data['post_id'] : null;

        $post = $this->_postInterface;

        $post->setContent($data['content']);
        $post->setTitle($data['title']);
        $post->setUrlKey($data['url_key']);
        $post->setIsActive($data['status']);
        $post->setCreationTime($this->_dateTime->gmtDate());
        $post->setUpdateTime($this->_dateTime->gmtDate());

        if ($id) {
            $post->setId($id);
            $this->getMessageManager()->addSuccessMessage(__('Edit success'));
        } else {
            $this->getMessageManager()->addSuccessMessage(__('Save success'));
        }

        try{
            $this->_postRepository->save($post);
            $this->_redirect('blog/index/add');
        }catch (\Exception $e){
            $this->getMessageManager()->addErrorMessage(__('Save thất bại.'));
        }
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::post');
    }
}
