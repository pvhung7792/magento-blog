<?php
namespace OpenTechiz\Blog\Block\Adminhtml;

class Bloglist extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'OpenTechiz_Blog';
        $this->_controller = 'adminhtml_index';
        parent::_construct();
        $this->buttonList->remove('add');
    }
}
