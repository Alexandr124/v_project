<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml\Carousel;

class Delete extends \Vaimo\Carousel\Controller\Adminhtml\Carousel
{
    /**
     * @return $this
     */
    public function execute()
    {
        $carouselId = $this->getRequest()->getParam(static::PARAM_CRUD_ID);
        try {
            $carousel = $this->carouselFactory->create()->setId($carouselId);
            $carousel->delete();
            $this->messageManager->addSuccess(__('The carousel was deleted successfully'));
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
