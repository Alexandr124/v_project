<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Item\Helper\Renderer;

use Magento\Backend\Block\Context;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;
use Magento\Store\Model\StoreManagerInterface;
use Vaimo\Carousel\Model\ItemFactory;

class Image extends AbstractRenderer
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
        $storeViewId = $this->getRequest()->getParam('store');
        $item = $this->itemFactory->create()->setStoreViewId($storeViewId)->load($row->getId());
        $srcImage = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .
            $item->getImage();

        return '<image width="150" src ="' . $srcImage . '" alt="' . $item->getImage() . '">';
    }
}
