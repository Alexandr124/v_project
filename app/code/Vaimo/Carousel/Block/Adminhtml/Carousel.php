<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

class Carousel extends Container
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_carousel';
        $this->_blockGroup = 'Vaimo_Carousel';
        $this->_headerText = __('Carousels');
        $this->_addButtonLabel = __('Add New Carousel');
        parent::_construct();
    }
}
