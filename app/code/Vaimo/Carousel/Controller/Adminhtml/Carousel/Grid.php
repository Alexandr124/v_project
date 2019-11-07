<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class Grid extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        return $this->resultLayoutFactory->create();
    }
}
