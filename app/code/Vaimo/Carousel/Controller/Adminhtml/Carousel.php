<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml;

abstract class Carousel extends \Vaimo\Carousel\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'id';

    /**
     * Check if admin has permissions to visit related pages.
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vaimo_Carousel::carousel_custom_carousels');
    }
}
