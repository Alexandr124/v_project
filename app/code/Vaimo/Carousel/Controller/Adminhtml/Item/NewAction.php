<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

use Vaimo\Carousel\Controller\Adminhtml\Item;

class NewAction extends Item
{
    /**
     * @return mixed
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
