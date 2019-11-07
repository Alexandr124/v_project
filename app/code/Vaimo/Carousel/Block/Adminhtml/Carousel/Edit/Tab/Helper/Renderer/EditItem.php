<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel\Edit\Tab\Helper\Renderer;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;
use Vaimo\Carousel\Model\ItemFactory;

class EditItem extends AbstractRenderer
{
    /**
     * Store manager.
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Item factory.
     *
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ItemFactory $itemFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        ItemFactory $itemFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->itemFactory = $itemFactory;
    }

    /**
     * Render action.
     *
     * @param \Magento\Framework\DataObject $row
     *
     * @return string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        return '<a href="' . $this->getUrl('*/item/edit', [
            '_current' => false,
            'id' => $row->getId()
        ]) . '" target="_blank">' . __('Edit') . '</a>';
    }
}
