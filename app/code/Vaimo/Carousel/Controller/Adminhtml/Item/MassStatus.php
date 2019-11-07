<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Item;

class MassStatus extends \Vaimo\Carousel\Controller\Adminhtml\Item
{
    /**
     * @return $this
     */
    public function execute()
    {
        $itemIds = $this->getRequest()->getParam('item');
        $status = $this->getRequest()->getParam('status');
        $storeViewId = $this->getRequest()->getParam('store');

        if (!is_array($itemIds) || empty($itemIds)) {
            $this->messageManager->addError(__('Please select carousel item(s).'));
        } else {
            $itemCollection = $this->itemCollectionFactory->create()
                ->setStoreViewId($storeViewId)
                ->addFieldToFilter('id', ['in' => $itemIds]);
            try {
                foreach ($itemCollection as $item) {
                    $item->setStoreViewId($storeViewId)
                        ->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 item(s) status have been changed.', count($itemIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/', ['store' => $this->getRequest()->getParam('store')]);
    }
}
