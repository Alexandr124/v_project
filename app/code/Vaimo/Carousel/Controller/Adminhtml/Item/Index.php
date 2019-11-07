<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

class Index extends \Vaimo\Carousel\Controller\Adminhtml\Item
{
    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');

            return $resultForward;
        }

        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }
}
