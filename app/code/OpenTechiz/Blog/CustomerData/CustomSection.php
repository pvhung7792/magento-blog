<?php
namespace OpenTechiz\Blog\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Framework\DataObject;
use Magento\Customer\Model\Session;
use OpenTechiz\Blog\Block\UnpublishComment;
use Magento\Framework\App\RequestInterface;

class CustomSection extends DataObject implements SectionSourceInterface
{
    protected $unpublishComment;

    protected $_request;

    protected $_session;

    public function __construct(UnpublishComment $unpublishComment,
                                Session $session,
                                RequestInterface $request)
    {
        $this->unpublishComment = $unpublishComment;
        $this->_session= $session;
        $this->_request= $request;
    }

    public function getSectionData()
    {
        $customerID= $this->_session->getCustomerId();
        if (!$customerID){
            return null;
        }
        $commentLists = $this->unpublishComment->getComments(1);
        foreach ($commentLists as $comment){
            $comments[] = [
                'comment'=>$comment->getContent(),
                'post_id'=>$comment->getPostId(),
                'creation_time'=>$comment->getCreationTime()];
        }
        $data = ['comments' => $comments];
        return $data;
    }
}
