<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class Items extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();

        $resultLayout
            ->getLayout()->getBlock('carousel.carousel.edit.tab.items')
            ->setInItem($this->getRequest()->getPost('item', null));

        return $resultLayout;
    }
}
