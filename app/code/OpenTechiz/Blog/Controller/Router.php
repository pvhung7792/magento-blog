<?php
namespace OpenTechiz\Blog\Controller;

use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;
use OpenTechiz\Blog\Model\PostFactory;

class Router implements RouterInterface
{
    protected $actionFactory;
    protected $_postFactory;

    public function __construct(
        ActionFactory $actionFactory,
        PostFactory $postFactory
    )
    {
        $this->actionFactory = $actionFactory;
        $this->_postFactory = $postFactory;
    }

    public function match(RequestInterface $request)
    {
        $url_key = str_replace('/blog/','',$request->getPathInfo());
        $url_key = rtrim($url_key,'/');

        $post= $this->_postFactory->create();
        $post_id= $post->checkUrlKey($url_key);
        // $this->logger->debug( var_dump($post_id));

        if  (!$post_id)
        {
            return null;
        }

        $request->setModuleName('blog')->setControllerName('view')->setActionName('Index')->setParam('post_id',$post_id);

        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS,$url_key);

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
