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

        $url = str_replace('/blog/','',$request->getPathInfo());
        $url = trim($url, '/');
        $url = explode('/',$url);

        $controller = $url[0];

        if ($controller == 'view'){
            $url_key = $url[1];
            $post= $this->_postFactory->create();
            $post_id= $post->checkUrlKey($url_key);
            if  (!$post_id)
            {
                return null;
            }

            $request->setModuleName('blog')->setControllerName('view')->setActionName('Index')->setParam('post_id',$post_id);
            $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS,$url_key);
        }else{

            $action = $url[1];
            $paramName = isset($url[2])? $url[2] : '';
            $param = isset($url[3])? $url[3] : '';

            $request->setModuleName('blog')->setControllerName($controller)->setActionName($action);
        }

        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}
