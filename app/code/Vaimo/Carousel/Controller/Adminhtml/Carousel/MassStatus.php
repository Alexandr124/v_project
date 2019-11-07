<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class MassStatus extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @return $this
     */
    public function execute()
    {
        $carouselIds = $this->getRequest()->getParam('carousel');
        $status = $this->getRequest()->getParam('status');
        if (!is_array($carouselIds) || empty($carouselIds)) {
            $this->messageManager->addError(__('Please select carousel(s).'));
        } else {
            try {
                $carouselCollection = $this->carouselCollectionFactory->create()
                    ->addFieldToFilter('id', ['in' => $carouselIds]);

                foreach ($carouselCollection as $carousel) {
                    $carousel->setStatus($status)
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 carousel(s) status have been changed.', count($carouselIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
