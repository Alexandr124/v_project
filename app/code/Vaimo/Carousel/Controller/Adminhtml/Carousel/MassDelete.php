<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class MassDelete extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @return $this
     */
    public function execute()
    {
        $carouselIds = $this->getRequest()->getParam('carousel');
        if (!is_array($carouselIds) || empty($carouselIds)) {
            $this->messageManager->addError(__('Please select carousel(s).'));
        } else {
            $carouselCollection = $this->carouselCollectionFactory->create()
                ->addFieldToFilter('id', ['in' => $carouselIds]);
            try {
                foreach ($carouselCollection as $carousel) {
                    $carousel->delete();
                }
                $this->messageManager->addSuccess(
                    __('A total of %1 carousel(s) have been deleted.', count($carouselIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
