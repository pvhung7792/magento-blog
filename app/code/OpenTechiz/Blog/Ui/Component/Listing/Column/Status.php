<?php
namespace OpenTechiz\Blog\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('Disable')],
            ['value' => 1, 'label' => __('Enable')],
            ['value' => 2, 'label' => __('Pending')]
        ];
    }
}
