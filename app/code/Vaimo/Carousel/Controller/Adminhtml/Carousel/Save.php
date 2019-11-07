<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class Save extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @return $this|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();

        if (isset($formPostValues['carousel'])) {
            $carouselData = $formPostValues['carousel'];
            $carouselId = isset($carouselData['id']) ? $carouselData['id'] : null;

            $model = $this->carouselFactory->create();
            $model->load($carouselId);
            $model->setData($carouselData);

            try {
                $model->save();

                if (isset($formPostValues['carousel_item'])) {
                    $itemGridSerializedInputData = $this->jsHelper->decodeGridSerializedInput($formPostValues['carousel_item']);
                    $itemIds = [];
                    foreach ($itemGridSerializedInputData as $key => $value) {
                        $itemIds[] = $key;
                        $itemOrders[] = $value['sort_order'];
                    }

                    $unSelecteds = $this->itemCollectionFactory
                        ->create()
                        ->setStoreViewId(null)
                        ->addFieldToFilter('carousel_id', $model->getId());

                    if (count($itemIds)) {
                        $unSelecteds->addFieldToFilter('id', array('nin' => $itemIds));
                    }

                    foreach ($unSelecteds as $item) {
                        $item->setCarouselId(0)
                            ->setStoreViewId(null)
                            ->setSortOrder(0)->save();
                    }

                    $selectItem = $this->itemCollectionFactory
                        ->create()
                        ->setStoreViewId(null)
                        ->addFieldToFilter('id', array('in' => $itemIds));

                    $i = -1;
                    foreach ($selectItem as $item) {
                        $item->setCarouselId($model->getId())
                            ->setStoreViewId(null)
                            ->setSortOrder($itemOrders[++$i])->save();
                    }
                }

                $this->messageManager->addSuccess(__('The carousel has been saved.'));
                $this->_getSession()->setFormData(false);

                return $this->getBackResultRedirect($resultRedirect, $model->getId());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the carousel.'));
            }

            $this->_getSession()->setFormData($formPostValues);

            return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $carouselId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
