<?php
namespace OpenTechiz\Blog\Block\Adminhtml\Bloglist;

use Magento\Backend\Block\Widget\Grid as WidgetGrid;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \OpenTechiz\Blog\Model\ResourceModel\Post\Collection
     */
    protected $_blogCollection;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \OpenTechiz\Blog\Model\ResourceModel\Post\Collection $blogCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \OpenTechiz\Blog\Model\ResourceModel\Post\Collection $blogCollection,
        array $data = []
    ) {
        $this->_blogCollection = $blogCollection;
        parent::__construct($context, $backendHelper, $data);
        $this->setEmptyText(__('No Blogs Found'));
    }

    /**
     * Initialize the Blog collection
     *
     * @return WidgetGrid
     */
    protected function _prepareCollection()
    {
        $this->setCollection($this->_blogCollection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'post_id',
            ['header' => __('ID'),
                'index' => 'post_id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
            ]
        );
        $this->addColumn(
            'creation_time',
            [
                'header' => __('Create time'),
                'index' => 'creation_time',
            ]
        );
        $this->addColumn(
            'update_time',
            [
                'header' => __('Update time'),
                'index' => 'update_time',
            ]
        );
        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'index' => 'is_active',
                'frame_callback' => [$this, 'decorateStatus']
            ]
        );
        return $this;
    }

    /**
     * @param $value
     * @return string
     */
    public function decorateStatus($value) {
        $class = '';
        $text = '';
        switch ($value) {
            case '1':
                $class = 'grid-severity-notice';
                $text = 'enable';
                break;
            case '0':
            default:
                $class = 'grid-severity-critical';
                $text = 'disable';
                break;
        }
        return '<span class="' . $class . '"><span>' . __($text) . '</span></span>';
    }
}
