<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml;

use Magento\Framework\Controller\Result\Redirect;

abstract class Item extends \Vaimo\Carousel\Controller\Adminhtml\AbstractAction
{
    const PARAM_CODE = 'id';

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vaimo_Carousel::carousel_custom_items');
    }

    /**
     * Get back result redirect after add/edit action.
     *
     * @param Redirect $resultRedirect
     * @param null $paramCrudId
     *
     * @return Redirect
     */
    protected function getBackResultRedirect(Redirect $resultRedirect, $paramCrudId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                        'store' => $this->getRequest()->getParam('store'),
                        'current_carousel_id' => $this->getRequest()->getParam('current_carousel_id'),
                        'saveandclose' => $this->getRequest()->getParam('saveandclose'),
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
