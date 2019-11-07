<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

class MassDelete extends \Vaimo\Carousel\Controller\Adminhtml\Item
{
    /**
     * @return $this
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('item');
        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select carousel item(s).'));
        } else {
            $itemCollection = $this->itemCollectionFactory->create()
                ->addFieldToFilter('id', ['in' => $itemIds]);
            try {
                foreach ($itemCollection as $item) {
                    $item->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 item(s) have been deleted.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
