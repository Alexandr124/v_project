<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

class Delete extends \Vaimo\Carousel\Controller\Adminhtml\Item
{
    /**
     * @return $this
     */
    public function execute()
    {
        $itemId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
        try {
            $item = $this->itemFactory->create()->setId($itemId);
            $item->delete();
            $this->messageManager->addSuccess(__('The carousel item was deleted successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
